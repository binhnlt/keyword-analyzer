<?php

namespace App\Service\DomExtractor;

class GoogleSearchExtractor extends BaseSearchExtractor
{
    /**
     * @inheritDoc
     */
    public function getAdsNumberOnPage(): int
    {
        return $this->crawler->filter('.ads-visurl')->count();
    }

    /**
     * @inheritDoc
     */
    public function getLinkNumberOnPage(): int
    {
        return $this->crawler->filter('a')->count();
    }

    /**
     * @inheritDoc
     */
    public function getResultStatsString(): string
    {
        try {
            return trim($this->crawler->filter('#resultStats')->text());
        } catch (\InvalidArgumentException $ex) {
            if ('The current node list is empty.' == $ex->getMessage()) {
                return '';
            }
            throw $ex;
        }
    }

    /**
     * Extract number of total result from stats string from Google Search
     *
     * @param string $statsstring Google search stats string
     * @return integer
     */
    public function getTotalResultNumberFromStatsString(string $statsstring): int
    {
        if (empty($statsstring)) return 0;

        // Get string before '(' character
        $segments = explode("(", $statsstring, 2);
        $resultString = reset($segments);

        return (int)filter_var($resultString, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    }

    /**
     * Extract number of search execution time from stats string from Google Search
     *
     * @param string $statsstring Google search stats string
     * @return integer
     */
    public function getExecutionTimeFromStatsString(string $statsstring): float
    {
        if (empty($statsstring)) return 0;

        // Get string after '(' character
        $segments = explode("(", $statsstring, 2);
        $resultString = end($segments);

        return (float)filter_var($resultString, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    }
}
