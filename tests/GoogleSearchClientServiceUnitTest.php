<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Service\GoogleSearchClientService;
use GuzzleHttp\Psr7\Response;

class GoogleSearchClientServiceUnitTest extends TestCase
{
    protected $googleSearchClientService = null;

    protected $search_response = null;

    public function setUp()
    {
        $this->googleSearchClientService = new GoogleSearchClientService();
    }

    public function testGetSearchNameFunctionExpectGoogle()
    {
        $actual = $this->googleSearchClientService->getSearchName();

        $this->assertEquals('google', $actual);
    }

    public function testDoSearchFunctionExpectCorrectResponseInstance()
    {
        sleep(random_int(1, 10)); // Random time to prevent too many request
        $actual = $this->search_response = $this->googleSearchClientService->setKeyword('google')->doSearch();

        // Check if successuly response
        $this->assertTrue($actual instanceof Response);
        // Check if google reponse Good status
        $this->assertEquals(200, $actual->getStatusCode());
    }

    /**
     * @depends self::testDoSearchFunctionExpectCorrectResponseInstance()
     */
    public function testSearchResponseContentTypeExpectString()
    {
        $actual = $this->search_response->getBody()->getContents();

        $this->assertTrue(is_string($actual));
    }
}
