<?php

namespace Esat;

use Esat\Http\MockHttpClient;
use Esat\Support\Services\HttpService;
use GuzzleHttp\Psr7\Response;
use Monolog\Logger;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

/**
 * Class Http_TestCase
 * @package Esat
 */
class HttpServiceTest extends Base_TestCase
{
    /**
     * @var MockHttpClient
     */
    protected $mockHttpClient;

    /**
     * @var HttpService
     */
    protected $httpService;

    /**
     * @throws \InvalidArgumentException
     * @throws \PHPUnit\Framework\Exception
     */
    public function setUp()
    {
        parent::setUp();

        // Setup mock http client
        $this->mockHttpClient = new MockHttpClient();
        $this->httpService = $this->getMockForAbstractClass(HttpService::class, [$this->getEsat(), new Logger('esat.sdk'), $this->getMockHttpClient()]);
    }

    /**
     * @covers \Esat\Support\Services\HttpService::getErrorFromLastResponse
     *
     * @throws \Exception
     */
    public function testGetErrorFromLastResponse()
    {
        // Create
        $bodyWithError = [
            'error' => substr(md5(rand()), 20),
        ];
        $this->getMockHttpClient()->setMockResponse(new Response(SymfonyResponse::HTTP_NOT_FOUND, [], json_encode($bodyWithError)));

        // Assert response
        $this->assertEquals($this->httpService->getErrorFromLastResponse($this->getMockHttpClient()->getMockResponse()), $bodyWithError['error']);

        // Create
        $bodyWithMessage = [
            'message' => substr(md5(rand()), 20),
        ];
        $this->getMockHttpClient()->setMockResponse(new Response(SymfonyResponse::HTTP_NOT_FOUND, [], json_encode($bodyWithMessage)));

        // Assert response
        $this->assertEquals($this->httpService->getErrorFromLastResponse($this->getMockHttpClient()->getMockResponse()), $bodyWithMessage['message']);
    }

    /**
     * @return MockHttpClient
     */
    public function getMockHttpClient()
    {
        return $this->mockHttpClient;
    }
}
