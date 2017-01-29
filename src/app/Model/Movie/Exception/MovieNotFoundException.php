<?php
/**
 * Indicates that a movie wasn't found
 *
 * @author Maciej Mrug-Bazylczuk <maciej.mrug@gmail.com>
 */
namespace OMDBFinder\Model\Movie\Exception;

class MovieNotFoundException extends \RuntimeException {

    public function __construct() {
        parent::__construct('No movie found!');
    }
}