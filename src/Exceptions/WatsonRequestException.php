<?php

namespace WatsonSdkPhp\Exceptions;

class WatsonRequestException extends \Exception {
    /**
     * WatsonRequestException constructor.
     *
     * @param null $message
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct($message = null, $code = 0, \Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    /**
     * Exception string representation
     * 
     * @return string
     */
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}
