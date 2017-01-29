<?php
/**
 * Indicates and error when searching for a movie
 *
 * @author Maciej Mrug-Bazylczuk <maciej.mrug@gmail.com>
 */
namespace OMDBFinder\Model\Movie\Exception;

use OMDBFinder\Dictionary\UserMessages;

class MovieFindingErrorException extends \RuntimeException {

    public function __construct($message) {
        parent::__construct(UserMessages::ERROR_FINDING_MOVIE . $message);
    }
}