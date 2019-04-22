<?php

namespace App\Service;

class GoogleSearchClientService extends BaseSearchClientService
{

    /**
     * @inheritDoc
     */
    protected function getQueryString(): array
    {
        return [
            // Set keyword into query string
            'q' => $this->getKeyword(),
            'oq' => $this->getKeyword(),
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
}
