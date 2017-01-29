<?php
/**
 * Indicates a problem in connectiong with an API
 *
 * @author Maciej Mrug-Bazylczuk <maciej.mrug@gmail.com>
 */

namespace OMDBFinder\Infrastructure\Api\Exception;

class ServiceUnavailableException extends \RuntimeException {

    /**
     * @param string $message
     */
    public function __construct($message) {
        $message = 'There was an error in communicating with an external API: ' . $message;
        parent::__construct($message);
    }
}