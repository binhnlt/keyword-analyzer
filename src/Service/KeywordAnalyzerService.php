<?php

namespace App\Service;

use App\Entity\Keyword;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\KeywordReport;

class KeywordAnalyzerService
{

    /**
     * @var EntitymanagementInterface
     */
    private $_em = null;

    /**
     * @var GoogleSearchClientService
     */
    private $searchClientService = null;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->_em = $entityManager;
    }

    /**
     * Get report overview for all keyword
     *
     * @return array
     */
    public function getOverviewReport()
    {
        $keywordData = [];
        $keywords = $this->getKeywordRepository()->findBy([], ['keyword' => 'asc']);

        if($keywords)

        foreach ($keywords as $keywordEntity) {
            $data = $keywordEntity->toData();
            
            if ($keywordEntity->getLatestReport()) {
                $data['last_report'] = $keywordEntity->getLatestReport()->toData();
            }

            $keywordData[] = $data;
        }

        return ['keywords' => $keywordData];
    }

    /**
     * Get all reports for specificed keyword by ID
     *
     * @param integer $keywordId
     * @return array|null
     */
    public function getDetailByKeywordId(int $keywordId)
    {
        $keywordEntity = $this->getKeywordRepository()->find($keywordId);

        if (!$keywordEntity) {
            return null;
        }

        $reports = $this->getKeywordReportRepository()->findAllByKeywordId($keywordId);
        $data = $keywordEntity->toData();
        $data['reports'] = [];

        foreach ($reports as $reportEntity) {
            $data['reports'][] = $reportEntity->toData();
        }

        return $data;
    }

    /**
     * Get all reports for specificed keyword by ID
     *
     * @param integer $keywordId
     * @return 
     */
    public function getCachedPageByReportId(int $reportId)
    {
        $report = $this->getKeywordReportRepository()->find($reportId);

        if (!$report) {
            return null;
        }

        return [
            'id'           => $report->getId(),
            'keyword'      => $report->keyword->toData(),
            'page_content' => $report->getPageContent(),
        ];
    }


    /**
     * Perform executing search and create report for keyword
     *
     * @param string $keyword
     * @return Keyword
     */
    public function analyzeKeyword(string $keyword): Keyword
    {
        $keywordEntity = $this->getKeywordRepository()->findOneOrCreate($keyword);
        $keywordEntity->addReport($this->getKeywordReport($keywordEntity));

        $this->_em->persist($keywordEntity);
        $this->_em->flush();

        return $keywordEntity;
    }

    private function getKeywordReport(Keyword $keywordEntity): KeywordReport
    {
        $searchResponse = $this->getSearchClientService()->setKeyword($keywordEntity->getKeyword())->doSearch();
        $extractor = $this->getSearchClientService()->getExtractorService();

        $pageContent = $searchResponse->getBody()->getContents();
        $extractor->setHtmlContent($pageContent);

        $report = new KeywordReport();
        $report->keyword = $keywordEntity;
        $report->setSource($this->getSearchClientService()->getSearchName());
        $report->setAdwordsNumber($extractor->getAdsNumberOnPage());
        $report->setLinksNumber($extractor->getLinkNumberOnPage());
        $report->setSearchTime($extractor->getExecutionTimeFromStatsString($extractor->getResultStatsString()));
        $report->setResultNumber($extractor->getTotalResultNumberFromStatsString($extractor->getResultStatsString()));
        $report->setPageContent($pageContent);

        return $report;
    }

    /**
     * @return \App\Repository\KeywordRepository
     */
    private function getKeywordRepository()
    {
        return $this->_em->getRepository(Keyword::class);
    }

    /**
     * @return \App\Repository\KeywordReportRepository
     */
    private function getKeywordReportRepository()
    {
        return $this->_em->getRepository(KeywordReport::class);
    }

    /**
     * @return GoogleSearchClientService
     */
    private function getSearchClientService()
    {
        if (!$this->searchClientService) {
            $this->searchClientService = new GoogleSearchClientService();
        }

        return $this->searchClientService;
    }
}
