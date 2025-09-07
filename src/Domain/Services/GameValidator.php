<?php

namespace App\Domain\Services;

use App\Domain\Exception\TrisMoveException;
use App\Domain\Model\Game;
use App\Domain\Model\GameConstants;
use App\Utils;

class GameValidator
{


    /**
     * @param Game $game
     * @param string $user
     * @param string $coord
     * @return bool
     * @throws TrisMoveException
     */
    public function validateMove(Game $game, string $user, string $coord): bool
    {
        if (strlen($coord) > 3 || strlen($coord) < 3) {
            throw TrisMoveException::wrongBoardPosition($coord);
        }

        if (!$this->coordAreInRange($coord)) {
            throw TrisMoveException::wrongBoardPosition($coord);
        }

        if ($game->hasReachedMaxMoves() || !$game->isOpen()) {
            throw TrisMoveException::noMoreMove();
        }

        if ($game->existsStep($coord)) {
            throw TrisMoveException::positionAlreadyTaken($coord);
        }

        $steps = $game->getStephistory();
        $latestUserToMove = end($steps);
        if ($latestUserToMove && $latestUserToMove == $user) {
            throw TrisMoveException::isNotYourTurn($user);
        }
        return true;
    }


    private function coordAreInRange(string $coord): bool
    {
        $utils = new Utils();
        $xy = $utils->splitCoordinates($coord);
        return intval($xy["row"]) >= GameConstants::COORD_MIN && intval($xy["col"]) <= GameConstants::COORD_MAX;
    }


}
