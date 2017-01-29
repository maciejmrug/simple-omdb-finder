<?php
/**
 *
 * @author Maciej Mrug-Bazylczuk <maciej.mrug@gmail.com
 */
namespace OMDBFinder\Tests\Controller\Api\Movie;

use OMDBFinder\Controller\Api\Movie\GetMovieController;
use OMDBFinder\Dictionary\UserMessages;
use OMDBFinder\Model\Movie\{
    MovieFinder,
    Exception\MovieFindingErrorException,
    Exception\MovieNotFoundException
};
use Symfony\Component\HttpFoundation\{
    JsonResponse,
    Request
};

class FindMovieControllerTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var MovieFinder
     */
    private $movieFinderMock;

    /**
     * @var Request
     */
    private $requestMock;

    public function setUp() {
        $this->movieFinderMock = $this->getMockBuilder(MovieFinder::class)
            ->disableOriginalConstructor()
            ->setMethods(['findBy'])
            ->getMock();
        $this->requestMock = $this->createMock(Request::class);
    }

    /**
     * @covers GetMovieController::getMovie
     */
    public function testGetMovieMovieFoundShouldReturnResponse() {
        $finderResult = ['foo' => 'bar'];
        $this->movieFinderMock->method('findBy')
            ->will($this->returnValue($finderResult));
        
        $controller = new GetMovieController($this->movieFinderMock, $this->requestMock);
        $response = $controller->getMovie('title');
        $this->assertInstanceOf(JsonResponse::class, $response);

        $expectedPayload = ['foo' => 'bar'];
        $payloadFromResponse = json_decode($response->getContent(), true);
        $this->assertEquals($expectedPayload, $payloadFromResponse);
    }

    /**
     * @covers GetMovieController::getMovie
     */
    public function testGetMovieMovieNotFoundShouldReturnNotFoundResponse() {
        $this->movieFinderMock->method('findBy')
            ->will($this->throwException(new MovieNotFoundException()));

        $controller = new GetMovieController($this->movieFinderMock, $this->requestMock);
        $response = $controller->getMovie('title');
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(JsonResponse::HTTP_NOT_FOUND, $response->getStatusCode());

        $expectedPayload = ['notFound' => UserMessages::MOVIE_NOT_FOUND];
        $payloadFromResponse = json_decode($response->getContent(), true);

        $this->assertEquals($expectedPayload, $payloadFromResponse);
    }

    /**
     * @covers GetMovieController::getMovie
     */
    public function testGetMovieMovieFindingErrorShouldReturnErrorResponse() {
        $this->movieFinderMock->method('findBy')
            ->will($this->throwException(new MovieFindingErrorException('Some error')));

        $controller = new GetMovieController($this->movieFinderMock, $this->requestMock);
        $response = $controller->getMovie('title');
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, $response->getStatusCode());

        $expectedPayload = ['error' => UserMessages::ERROR_FINDING_MOVIE . 'Some error'];
        $payloadFromResponse = json_decode($response->getContent(), true);

        $this->assertEquals($expectedPayload, $payloadFromResponse);;
    }
}