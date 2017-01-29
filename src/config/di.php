<?php
/**
 * Dependency Injection configuration
 *
 * @author Maciej Mrug-Bazylczuk <maciej.mrug@gmail.com>
 */

/** @var \Silex\Application $app */
$app->register(new Silex\Provider\ServiceControllerServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), [
    'twig.path' => __DIR__.'/../web/views',
]);

$app['GuzzleClient'] = function() {
    return new \GuzzleHttp\Client();
};
$app['Infrastructure.Api.Omdb.QueryBuilder'] = function() use ($app) {
    return new OMDBFinder\Infrastructure\Api\Omdb\QueryBuilder($app['config']['omdbApi']);
};
$app['Infrastructure.Api.Omdb.ResponseFormatter'] = function() use ($app) {
    return new OMDBFinder\Infrastructure\Api\Omdb\ResponseFormatter($app['config']);
};
$app['Infrastructure.Api.Omdb.Client'] = function() use ($app) {
    return new OMDBFinder\Infrastructure\Api\Omdb\Client(
        $app['GuzzleClient'],
        $app['Infrastructure.Api.Omdb.QueryBuilder'],
        $app['Infrastructure.Api.Omdb.ResponseFormatter']
    );
};
$app['Model.Movie.MovieFinder'] = function() use ($app) {
    return new OMDBFinder\Model\Movie\MovieFinder($app['Infrastructure.Api.Omdb.Client']);
};
$app['Controller.IndexController'] = function() use ($app) {
    return new \OMDBFinder\Controller\IndexController($app);
};
$app['Controller.Api.Movie.GetMovieController'] = function() use ($app) {
    return new \OMDBFinder\Controller\Api\Movie\GetMovieController(
        $app['Model.Movie.MovieFinder'],
        $app['request_stack']->getCurrentRequest()
    );
};