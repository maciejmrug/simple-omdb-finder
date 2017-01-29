<?php
/**
 * Gets movie info by search params.
 * 
 * @author Maciej Mrug-Bazylczuk <maciej.mrug@gmail.com>
 */

namespace OMDBFinder\Controller\Api\Movie;

use \Silex\Application;
use \OMDBFinder\Dictionary\UserMessages;
use \OMDBFinder\Controller\Api\AbstractApiController;
use \OMDBFinder\Model\Movie\{
    MovieFinder,
    Exception\MovieFindingErrorException,
    Exception\MovieNotFoundException
};
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class GetMovieController extends AbstractApiController {

    /**
     * @var MovieFinder
     */
    private $movieFinder;

    /**
     * @var Request
     */
    private $request;

    public function __construct(MovieFinder $movieFinder, Request $request) {
        $this->movieFinder = $movieFinder;
        $this->request = $request;
    }

    /**
     * @return Response
     */
    public function getMovie() {
        try {
            return $this->okResponse($this->movieFinder->findBy([
                'title' => trim($this->request->get('title'))
            ]));
        } catch (MovieFindingErrorException $exception) {
            return $this->errorResponse($exception->getMessage());
        } catch (MovieNotFoundException $exception) {
            return $this->notFoundResponse(UserMessages::MOVIE_NOT_FOUND);
        }
    }
}