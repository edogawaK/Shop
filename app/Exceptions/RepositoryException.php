<?php

namespace App\Exceptions;

use Exception;

class RepositoryException extends Exception
{
    /**
     * Report or log an exception.
     *
     * @return void
     */
    public function report()
    {
        //
    }

    public function render($request)
    {
        return response()->json(
            [
                "status"=>0,
                "message"=>$this->message,
                "error_code"=>$this->code
            ]
        );
    }

    /* 
    code:
        0: model invalid
    */
}
