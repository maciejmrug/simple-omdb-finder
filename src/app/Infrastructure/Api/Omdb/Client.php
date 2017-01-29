<?php
/**
 * Uses OMDB API to find movies
 *
 * @author Maciej Mrug-Bazylczuk <maciej.mrug@gmail.com>
 */
namespace OMDBFinder\Infrastructure\Api\Omdb;

use Assert\{
    Assertion,
    InvalidArgumentException
};
use GuzzleHttp\{
    Client as GuzzleClient,
    Exception\RequestException
};
use OMDBFinder\Infrastructure\Api\Exception\{
    ServiceUnavailableException,
    NotFoundException,
    InvalidResponseException
};

class Client {

    /**
     * @var GuzzleClient
     */
    private $httpClient;

    /**
     * @var QueryBuilder
     */
    private $queryBuilder;

    /**
     * @var array
     */
    private $response;

    /**
     * @param GuzzleClient $httpClient
     * @param QueryBuilder $queryBuilder
     * @param ResponseFormatter $responseFormatter
     */
    public function __construct(
        GuzzleClient $httpClient,
        QueryBuilder $queryBuilder,
        ResponseFormatter $responseFormatter
    ) {
        $this->httpClient = $httpClient;
        $this->queryBuilder = $queryBuilder;
        $this->responseFormatter = $responseFormatter;
    }

    /**
     * @param array $params
     * @return string
     * @throws InvalidResponseException
     * @throws NotFoundException
     * @throws ServiceUnavailableException
     */
    public function getMovie(array $params) {
        try {
            $response = $this->makeRequest('GET', $params);
            $this->setResponseFromString($response);
            $this->validateMovieFound();
            return $this->responseFormatter->formatResponse($this->response);
        } catch (RequestException $e) {
            throw new ServiceUnavailableException($e->getMessage());
        }
    }

    /**
     * @param string $httpVerb
     * @param array $queryParams
     * @return string
     * @throws RequestException
     */
    protected function makeRequest($httpVerb, array $queryParams) {
        /** @var \Psr\Http\Message\ResponseInterface $response */
        $response = $this->httpClient->request($httpVerb, $this->queryBuilder->buildQuery($queryParams));
        return $response->getBody()->getContents();
    }

    /**
     * @param string $response
     * @throws InvalidResponseException
     */
    private function setResponseFromString($response) {
        try {
            Assertion::isJsonString($response);
        } catch (InvalidArgumentException $exception) {
            throw new InvalidResponseException();
        }
        $this->response = json_decode($response, true);
    }

    /**
     * @throws NotFoundException
     */
    private function validateMovieFound() {
        if (array_key_exists("Response", $this->response) && $this->response["Response"] == "False") {
            throw new NotFoundException();
        }
    }
}
