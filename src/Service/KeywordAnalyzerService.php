<?php

namespace App\Service;

use App\Entity\Keyword;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\KeywordReport;

class KeywordAnalyzerService
{

    private $_em = null;

    private $searchClientService = null;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->_em = $entityManager;
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
        $keywordEntity->reports[] = $this->getKeywordReport($keywordEntity);

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
        $report->keyword = $keywordEntity->getId();
        $report->setSource($this->getSearchClientService()->getSearchName());
        $report->setAdwordsNumber($extractor->getAdsNumberOnPage());
        $report->setLinksNumber($extractor->getLinkNumberOnPage());
        $report->setSearchTime($extractor->getExecutionTimeFromStatsString($extractor->getResultStatsString()));
        $report->setResultNum($extractor->getTotalResultNumberFromStatsString($extractor->getResultStatsString()));
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
