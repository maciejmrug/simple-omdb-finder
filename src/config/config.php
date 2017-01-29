<?php

return [
    'staticResourceRegex' => '/\.(?:png|jpg|js|css)$/',
    'frontApp' => [
        'url' => 'build.js',
        'omdbFinderApiEndpoint' => 'api/movies/find/'
    ],
    'omdbApi' => [
        'baseUrl' => 'http://www.omdbapi.com',
        'imdbUrlSchema' => 'http://www.imdb.com/title/%s/'
    ]
];