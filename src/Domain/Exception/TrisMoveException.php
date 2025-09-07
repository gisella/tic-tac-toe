<?php

namespace App\Domain\Exception;

use Exception;

class TrisMoveException extends Exception
{

    public static function positionAlreadyTaken(string $coord): self
    {
        return new self('Position already taken ' . $coord);
    }

    public static function wrongBoardPosition(string $coord): self
    {
        return new self('Wrong board position' . $coord);
    }

    public static function isNotYourTurn(string $user): self
    {
        return new self('Wrong board position ' . $user);
    }


}
