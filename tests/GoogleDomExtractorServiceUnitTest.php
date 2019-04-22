<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Service\DomExtractor\GoogleSearchExtractor;

class GoogleDomExtractorServiceUnitTest extends TestCase
{
    public function testExtractResultOnKeywordWithoutResult()
    {
        $extractor = new GoogleSearchExtractor(file_get_contents(__DIR__ . '/mocks/html/keyword_without_result.html'));

        $actualAdsNumber = $extractor->getAdsNumberOnPage();
        $actualLinksNumber = $extractor->getLinkNumberOnPage();
        $actualStats = $extractor->getResultStatsString();

        $this->assertEquals(0, $actualAdsNumber);
        $this->assertEquals(74, $actualLinksNumber);
        $this->assertTrue(empty($actualStats));
    }

    public function testExtractResultOnKeywordWithoutAds()
    {
        $extractor = new GoogleSearchExtractor(file_get_contents(__DIR__ . '/mocks/html/keyword_without_ads.html'));

        $actualAdsNumber = $extractor->getAdsNumberOnPage();
        $actualLinksNumber = $extractor->getLinkNumberOnPage();
        $actualStats = $extractor->getResultStatsString();

        $this->assertEquals(0, $actualAdsNumber);
        $this->assertEquals(130, $actualLinksNumber);
        $this->assertEquals('Khoảng 25.270.000.000 kết quả (0,38 giây) ', $actualStats);
    }

    public function testExtractResultOnKeywordWithAds()
    {
        $extractor = new GoogleSearchExtractor(file_get_contents(__DIR__ . '/mocks/html/keyword_with_4_ads.html'));

        $actualAdsNumber = $extractor->getAdsNumberOnPage();
        $actualLinksNumber = $extractor->getLinkNumberOnPage();
        $actualStats = $extractor->getResultStatsString();

        $this->assertEquals(4, $actualAdsNumber);
        $this->assertEquals(148, $actualLinksNumber);
        $this->assertEquals('About 14,300,000 results (0.60 seconds) ', $actualStats);
    }
}
