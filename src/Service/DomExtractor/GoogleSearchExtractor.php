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
}
