<?php

namespace App\Application\Controller;

use App\Domain\Model\Game;
use App\Domain\Model\GameConstants;
use App\Utils;

class Translator
{
    /**
     * @param Game $game
     * @return array
     */
    public static function translateStepsToBoard(Game $game): array
    {
        $board = array();
        $utils = new Utils();
        for ($row = GameConstants::COORD_MIN; $row <= GameConstants::COORD_MAX; $row++) {
            for ($col = GameConstants::COORD_MIN; $col <= GameConstants::COORD_MAX; $col++) {
                $coord = $utils->getCoordinates($row, $col);
                $user = $game->getUserByCoord($coord);
                $board[] = array('user' => $user, 'col' => $col, 'row' => $row);
            }
        }
        return $board;
    }

}
