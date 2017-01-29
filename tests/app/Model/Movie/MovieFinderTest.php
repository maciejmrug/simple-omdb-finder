<?php
/**
 * Tests movie finder
 *
 * @author Maciej Mrug-Bazylczuk <maciej.mrug@gmail.com>
 */
namespace OMDBFinder\Tests\Model\Movie;

use OMDBFinder\Infrastructure\Api\{
    Omdb\Client as ApiClient,
    Exception\NotFoundException,
    Exception\ServiceUnavailableException
};
use OMDBFinder\Model\Movie\MovieFinder;

class MovieFinderTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var ApiClient
     */
    private $apiClientMock;

    public function setUp() {
        $this->apiClientMock = $this->getMockBuilder(ApiClient::class)
            ->disableOriginalConstructor()
            ->setMethods(['getMovie'])
            ->getMock();
    }

    /**
     * @covers MovieFinder::findBy
     * @expectedException \OMDBFinder\Model\Movie\Exception\MovieFindingErrorException
     */
    public function testFindMovieByTitleInvalidSearchParamsShouldThrowException() {
        $finder = new MovieFinder($this->apiClientMock);
        $this->assertEquals('foo', $finder->findBy(['invalid' => 'param']));
    }

    /**
     * @covers MovieFinder::findBy
     */
    public function testFindMovieByTitleMovieExistsShouldReturnMovie() {
        $this->apiClientMock->method('getMovie')
            ->willReturn('foo');

        $finder = new MovieFinder($this->apiClientMock);
        $this->assertEquals('foo', $finder->findBy(['title' => 'foo']));
    }

    /**
     * @covers MovieFinder::findBy
     * @expectedException \OMDBFinder\Model\Movie\Exception\MovieFindingErrorException
     */
    public function testFindMovieByTitleServiceUnavailableShouldThrowException() {
        $this->apiClientMock->method('getMovie')
            ->will($this->throwException(new ServiceUnavailableException('msg')));

        $finder = new MovieFinder($this->apiClientMock);
        $this->assertEquals('foo', $finder->findBy(['title' => 'foo']));
    }

    /**
     * @covers MovieFinder::findBy
     * @expectedException \OMDBFinder\Model\Movie\Exception\MovieNotFoundException
     */
    public function testFindMovieByTitleInfrastructureNotFoundShouldThrowException() {
        $this->apiClientMock->method('getMovie')
            ->will($this->throwException(new NotFoundException('msg')));

        $finder = new MovieFinder($this->apiClientMock);
        $this->assertEquals('foo', $finder->findBy(['title' => 'foo']));
    }
}