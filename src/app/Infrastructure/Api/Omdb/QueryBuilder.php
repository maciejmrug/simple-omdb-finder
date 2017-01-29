<?php
/**
 * Builds HTTP queries for the OMDB API
 *
 * @author Maciej Mrug-Bazylczuk <maciej.mrug@gmail.com>
 */
namespace OMDBFinder\Infrastructure\Api\Omdb;

class QueryBuilder {

    /**
     * @var array
     */
    private $config;

    /**
     * @param array $config
     */
    public function __construct(array $config) {
        $this->config = $config;
    }

    /**
     * @param array $params
     * @return string
     */
    public function buildQuery(array $params) {
        $query = $this->config['baseUrl'];
        $query .= '?' . http_build_query([
            's' => $params['title'],
            'r' => $this->config['responseType']
        ]);
        return $query;
    }
}
