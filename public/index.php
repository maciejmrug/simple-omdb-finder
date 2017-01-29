<?php
/**
 * Silex application entry point
 *
 * @author Maciej Mrug-Bazylczuk <maciej.mrug@gmail.com>
 */

/** @var array $config */
$config = require '../src/config/config.php';
redirectStatic($config['staticResourceRegex']);

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();
$app['config'] = $config;

require '../src/config/di.php';
require '../src/config/routes.php';

$app->run();

/**
 * Redirects requests to static resources to serve them
 * directly from the public directory
 *
 * @param string $staticResourceRegex
 * @return bool
 */
function redirectStatic($staticResourceRegex) {
    if (preg_match($staticResourceRegex, $_SERVER["REQUEST_URI"])) {
        return false;
    }
}