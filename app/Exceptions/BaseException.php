<?php

namespace App\Exceptions;

use Exception;

class BaseException extends Exception
{
    public $messages, $exceptionCode, $statusCode;
    public function __construct($messages = '', $exceptionCode = '', $statusCode = 400)
    {
        $this->$messages = $messages;
        $this->$exceptionCode = $exceptionCode;
        $this->$statusCode = $statusCode;
    }
}
