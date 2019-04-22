<?php

namespace App\Service\DomExtractor;

use Symfony\Component\DomCrawler\Crawler;

abstract class BaseSearchExtractor
{

    /**
     * @var Crawler
     */
    protected $crawler;

    /**
     * @var string
     */
    protected $htmlContent = '';

    /**
     * Get number of ads on page
     *
     * @return int
     */
    public abstract function getAdsNumberOnPage(): int;

    /**
     * Get number of links on page
     *
     * @return int
     */
    public abstract function getLinkNumberOnPage(): int;

    /**
     * Get search result stats on page
     *
     * @return string
     */
    public abstract function getResultStatsString(): string;


    public function __construct($htmlContent = '')
    {
        $this->crawler = new Crawler($htmlContent);
    }

    /**
     * Get HTML Content
     *
     * @return string
     */
    public function getHtmlContent(): string
    {
        return $this->htmlContent;
    }

    /**
     * Set HTML Content
     *
     * @param string $htmlContent
     * @return self
     */
    public function setHtmlContent(string $htmlContent): self
    {
        $this->htmlContent = $htmlContent;
        
        // Re-initialize crawler on new content
        $this->crawler = new Crawler($htmlContent);

        return $this;
    }
}
