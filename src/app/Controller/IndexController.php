<?php
/**
 * Shows index page of the app.
 *
 * @author Maciej Mrug-Bazylczuk <maciej.mrug@gmail.com>
 */

namespace OMDBFinder\Controller;

use \Silex\Application;
use \Symfony\Component\HttpFoundation\Response;

class IndexController {

    /**
     * @var Application
     */
    private $app;

    public function __construct(Application $app) {
        $this->app = $app;
    }

    /**
     * @return Response
     */
    public function get() {
        return $this->app['twig']->render('index.twig', [
            'frontAppUrl' => $this->app['config']['frontApp']['url'],
            'omdbFinderApiEndpoint' => $this->app['config']['frontApp']['omdbFinderApiEndpoint']
        ]);
    }
}