<?php
/**
 * Methods common to all API controllers.
 *
 * @author Maciej Mrug-Bazylczuk <maciej.mrug@gmail.com>
 */
namespace OMDBFinder\Controller\Api;

use Symfony\Component\HttpFoundation\JsonResponse;

class AbstractApiController {

    /**
     * @param array $payload
     * @return JsonResponse
     */
    public function okResponse(array $payload) {
        $response = new JsonResponse($payload);
        return $response;
    }

    /**
     * @param string $message
     * @return JsonResponse
     */
    public function errorResponse($message) {
        $response = new JsonResponse([
            'error' => $message
        ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        return $response;
    }

    /**
     * @param string $message
     * @return JsonResponse
     */
    public function notFoundResponse($message) {
        $response = new JsonResponse([
            'notFound' => $message
        ], JsonResponse::HTTP_NOT_FOUND);
        return $response;
    }
}
