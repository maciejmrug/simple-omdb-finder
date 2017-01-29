<?php
/**
 * Formats a response from the OMDB API
 *
 * @author Maciej Mrug-Bazylczuk <maciej.mrug@gmail.com>
 */
namespace OMDBFinder\Infrastructure\Api\Omdb;

class ResponseFormatter {

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
     * @param array $responseFromApi
     * @return array
     */
    public function formatResponse(array $responseFromApi) {
        $response = [];
        foreach ($responseFromApi['Search'] as $movieFromApi) {
            $item = [
                'title' => $movieFromApi['Title'],
                'type' => ucfirst($movieFromApi['Type']),
                'year' => $movieFromApi['Year'],
                'isPosterAvailable' => $this->isPosterAvailable($movieFromApi['Poster']),
                'posterUrl' => $movieFromApi['Poster'],
                'imdbUrl' => $this->getImdbUrl($movieFromApi['imdbID'])
            ];
            array_push($response, $item);
        };
        return $response;
    }

    /**
     * @param string $posterUrl
     * @return boolean
     */
    private function isPosterAvailable($posterUrl) {
        return filter_var($posterUrl, FILTER_VALIDATE_URL) !== false;
    }

    /**
     * @param string $imdbId
     * @return string
     */
    private function getImdbUrl($imdbId) {
        return sprintf($this->config['omdbApi']['imdbUrlSchema'], $imdbId);
    }
}