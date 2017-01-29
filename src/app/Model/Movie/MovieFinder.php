<?php
/**
 * Finds movies
 *
 * @author Maciej Mrug-Bazylczuk <maciej.mrug@gmail.com>
 */

namespace OMDBFinder\Model\Movie;

use OMDBFinder\Model\Movie\Exception\{
    MovieNotFoundException,
    MovieFindingErrorException
};
use OMDBFinder\Infrastructure\Api\{
    Omdb\Client as ApiClient,
    Exception\NotFoundException
};

class MovieFinder {

    /**
     * @var ApiClient
     */
    private $apiClient;

    /**
     * MovieFinder constructor.
     * @param ApiClient $apiClient
     */
    public function __construct(ApiClient $apiClient) {
        $this->apiClient = $apiClient;
    }

    /**
     * @param array $params
     * @throws MovieNotFoundException
     * @throws MovieFindingErrorException
     * @return array
     */
    public function findBy(array $params) {
        try {
            $this->validateParams($params);
            return $this->apiClient->getMovie($params);
        } catch (NotFoundException $exception) {
            throw new MovieNotFoundException();
        } catch (\Exception $exception) {
            throw new MovieFindingErrorException($exception->getMessage());
        }
    }

    /**
     * @param array $params
     * @throws MovieNotFoundException
     */
    private function validateParams(array $params) {
        if (empty($params['title'])) {
            throw new MovieNotFoundException();
        }
    }
}