<?php

namespace App\Domain\Repository;

use App\Document\Game;

interface GameRepositoryInterface
{
    public function save(Game $game): void;
    public function findById(string $gameId): ?Game;
}
