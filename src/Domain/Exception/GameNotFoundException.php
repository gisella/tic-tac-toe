<?php

namespace App\Domain\Exception;

use Exception;

class GameNotFoundException extends Exception
{

    public function __construct(string $message = "Game not found", int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }


}
