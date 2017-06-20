<?php

namespace WatsonSdkPhp\Exceptions;

class WatsonRequestException extends \Exception {
    public function __construct($message = null, $code = 0, \Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}
