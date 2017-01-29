<?php
/**
 * Defines application routes and mounts controllers
 *
 * @author Maciej Mrug-Bazylczuk <maciej.mrug@gmail.com>
 */

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;

$app->get('/', 'Controller.IndexController:get');
$app->get('/api/movies/find/', 'Controller.Api.Movie.GetMovieController:getMovie');

$app->error(function (\Exception $exception) use ($app) {
    if ($exception instanceof NotFoundHttpException) {
        return $app->redirect('/');
    }
    return new Response('We are sorry, but something went terribly wrong.', Response::HTTP_INTERNAL_SERVER_ERROR);
});