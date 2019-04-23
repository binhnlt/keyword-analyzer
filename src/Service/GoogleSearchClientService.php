<?php

namespace App\Service;

use App\Service\DomExtractor\BaseSearchExtractor;
use App\Service\DomExtractor\GoogleSearchExtractor;

class GoogleSearchClientService extends BaseSearchClientService
{

    private $extractorService = null;

    /**
     * @inheritDoc
     */
    protected function getQueryString(): array
    {
        return [
            // Set keyword into query string
            'q' => $this->getKeyword(),
            'oq' => $this->getKeyword(),
            'hl' => 'en', // Enforce using search by English page
        ];
    }

    /**
     * @inheritDoc
     */
    protected function getSearchRequestUrl(): string
    {
        return 'https://google.com/search';
    }

    /**
     * @inheritDoc
     */
    public function getSearchName(): string
    {
        return 'google';
    }

    /**
     * @return GoogleSearchExtractor
     */
    public function getExtractorService(): ?BaseSearchExtractor
    {
        if (!$this->extractorService) {
            $this->extractorService = new GoogleSearchExtractor();
        }

        return $this->extractorService;
    }
}
