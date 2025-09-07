<?php

namespace App;

use App\Domain\Model\GameConstants;

class Utils
{
    /**
     * @param string $coord
     * @return array
     */
    public function splitCoordinates(string $coord): array
    {
        $xy = explode(GameConstants::COORD_SEPARATOR, $coord);
        return ["row" => $xy[0], "col" => $xy[1]];
    }

    /**
     * @param int $row
     * @param int $col
     * @return string
     */
    public function getCoordinates(int $row, int $col): string
    {
        return $row . GameConstants::COORD_SEPARATOR . $col;
    }


}
