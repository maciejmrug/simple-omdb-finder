<?php
/**
 * Tests OMDB API client for various responses
 *
 * @author Maciej Mrug-Bazylczuk <maciej.mrug@gmail.com>
 */
namespace OMDBFinder\Tests\Infrastructure\Api\Omdb;

use OMDBFinder\Infrastructure\Api\Omdb\{
    Client as ApiClient,
    QueryBuilder,
    ResponseFormatter
};
use GuzzleHttp\{
    Client as GuzzleClient,
    Exception\RequestException
};

class ClientTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var GuzzleClient
     */
    private $httpClientMock;

    /**
     * @var QueryBuilder
     */
    private $queryBuilderMock;

    /**
     * @var ResponseFormatter
     */
    private $responseFormatterMock;

    /**
     * @var ApiClient
     */
    private $apiClientMock;

    public function setUp() {
        $this->httpClientMock = $this->createMock(GuzzleClient::class);
        $this->queryBuilderMock = $this->createMock(QueryBuilder::class);
        $this->responseFormatterMock = $this->createMock(ResponseFormatter::class);
        $this->apiClientMock = $this->getMockBuilder(ApiClient::class)
            ->setConstructorArgs([
                $this->httpClientMock,
                $this->queryBuilderMock,
                $this->responseFormatterMock
            ])
            ->setMethods(['makeRequest'])
            ->getMock();
    }

    /**
     * @covers Client::getMovie
     * @expectedException \OMDBFinder\Infrastructure\Api\Exception\InvalidResponseException
     */
    public function testGetMovieInvalidResponseFromApiShouldThrowException() {
        $this->apiClientMock->method('makeRequest')
            ->will($this->returnValue('abc'));

        $this->apiClientMock->getMovie(['title' => 'Some Like It Hot']);
    }

    /**
     * @covers Client::getMovie
     * @expectedException \OMDBFinder\Infrastructure\Api\Exception\NotFoundException
     */
    public function testGetMovieMovieNotFoundShouldThrowException() {
        $responseFromApi = [
            'Response' => 'False'
        ];

        $this->apiClientMock->method('makeRequest')
            ->will($this->returnValue(json_encode($responseFromApi)));

        $this->apiClientMock->getMovie(['title' => 'Some Like It Hot']);
    }

    /**
     * @covers Client::getMovie
     * @expectedException \OMDBFinder\Infrastructure\Api\Exception\ServiceUnavailableException
     */
    public function testGetMovieServiceUnavailableShouldThrowException() {
        $requestExceptionMock = $this->createMock(RequestException::class);

        $this->apiClientMock->method('makeRequest')
            ->will($this->throwException($requestExceptionMock));

        $this->apiClientMock->getMovie(['title' => 'Some Like It Hot']);
    }
}