<?php
/**
 * Tests behaviour common to all Api controllers
 *
 * @author Maciej Mrug-Bazylczuk <maciej.mrug@gmail.com
 */
namespace OMDBFinder\Tests\Controller\Api;

use OMDBFinder\Controller\Api\AbstractApiController;
use Symfony\Component\HttpFoundation\JsonResponse;

class AbstractApiControllerTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var AbstractApiController
     */
    private $abstractApiController;

    public function setUp() {
        $this->abstractApiController = new AbstractApiController();
    }

    /**
     * @covers AbstractApiController::okResponse
     */
    public function testOkResponseShouldReturnResponse() {
        $response = $this->abstractApiController->okResponse(['key' => 'value']);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
    }

    /**
     * @covers AbstractApiController::errorResponse
     */
    public function testErrorResponseShouldReturnErrorResponse() {
        $errorMsg = 'There was an error';
        $response = $this->abstractApiController->errorResponse($errorMsg);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, $response->getStatusCode());
    }

    /**
     * @covers AbstractApiController::notFoundResponse
     */
    public function testNotFoundResponseShouldReturnNotFoundResponse() {
        $notFoundMsg = 'Not found';
        $response = $this->abstractApiController->notFoundResponse($notFoundMsg);
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(JsonResponse::HTTP_NOT_FOUND, $response->getStatusCode());
    }
}