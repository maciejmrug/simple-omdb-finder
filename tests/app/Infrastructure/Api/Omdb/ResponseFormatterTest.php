<?php
/**
 * Tests the response formatter that formats responses from OMDB Api
 *
 * @author Maciej Mrug-Bazylczuk <maciej.mrug@gmail.com>
 */
namespace OMDBFinder\Tests\Infrastructure\Api\Omdb;

use OMDBFinder\Infrastructure\Api\Omdb\ResponseFormatter;

class ResponseFormatterTest extends \PHPUnit_Framework_TestCase {

    /**
     * @return array
     */
    public function providerTestFormatResponse() {
        $sampleResultFromApi =  [
            'Title' => 'Some Like It Hot',
            'Year' => '1959',
            'Type' => 'movie',
            'Poster' => 'https://images/image.jpg',
            'Response' => 'True',
            'imdbID' => 'abcd1234'
        ];
        $responseFromApiPosterAvailable = [
            'Search' => [
                $sampleResultFromApi
            ]
        ];
        $formattedResponsePosterAvailable = [
            [
                'title' => $sampleResultFromApi['Title'],
                'year' => $sampleResultFromApi['Year'],
                'type' => ucfirst($sampleResultFromApi['Type']),
                'posterUrl' => $sampleResultFromApi['Poster'],
                'isPosterAvailable' => true,
                'imdbUrl' => 'http://www.imdb.com/title/' . $sampleResultFromApi['imdbID'] . '/'
            ]
        ];

        $config = [
            'omdbApi' => [
                'imdbUrlSchema' => 'http://www.imdb.com/title/%s/'
            ]
        ];

        return [
            [
                $responseFromApiPosterAvailable,
                $formattedResponsePosterAvailable,
                $config
            ]
        ];
    }

    /**
     * @dataProvider providerTestFormatResponse
     * @param array $apiResponse
     * @param array $formattedResponse
     * @param array $config
     */
    public function testFormatResponseShouldReturnFormattedResponse(
        array $apiResponse,
        array $formattedResponse,
        array $config
    ) {

        $responseFormatter = new ResponseFormatter($config);
        $this->assertEquals($formattedResponse, $responseFormatter->formatResponse($apiResponse));
    }
}