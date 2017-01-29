<?php
/**
 * Tests whether correct queries are built to communicate with OMDB API
 *
 * @author Maciej Mrug-Bazylczuk <maciej.mrug@gmail.com>
 */
namespace OMDBFinder\Tests\Infrastructure\Api\Omdb;

use OMDBFinder\Infrastructure\Api\Omdb\QueryBuilder;

class QueryBuilderTest extends \PHPUnit_Framework_TestCase {

    /**
     * @return array
     */
    public function providerTestBuildQueryShouldReturnQuery() {
        return [
            [
                [
                    'baseUrl' => 'http://some-url/',
                    'responseType' => 'json'
                ],
                ['title' => 'foo'],
                'http://some-url/?s=foo&r=json'
            ],
            [
                [
                    'baseUrl' => 'http://some-other-url/',
                    'responseType' => 'xml'
                ],
                ['title' => 'some title'],
                'http://some-other-url/?s=some+title&r=xml'
            ]
        ];
    }

    /**
     * @covers \OMDBFinder\Infrastructure\Api\Imdb\QueryBuilder::buildQuery
     * @dataProvider providerTestBuildQueryShouldReturnQuery
     * @param array $apiConfig
     * @param array $params
     * @param string $expectedQuery
     */
    public function testBuildQueryShouldReturnQuery(array $apiConfig, array $params, $expectedQuery) {
        $apiClient = new QueryBuilder($apiConfig);
        $this->assertEquals($expectedQuery, $apiClient->buildQuery($params));
    }
}
