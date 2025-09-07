<?php

namespace App\Domain\Services;

use App\Domain\Exception\GameNotFoundException;
use App\Domain\Model\Game;
use App\Utils;
use Doctrine\ODM\MongoDB\DocumentManager;

class GameService
{
    private DocumentManager $documentManger;
    private GameValidator $gameValidator;

    public function __construct(GameValidator $gameValidator, DocumentManager $documentManager)
    {
        $this->gameValidator = $gameValidator;
        $this->documentManger = $documentManager;
    }

    /**
     * @return Game
     * @throws \Doctrine\ODM\MongoDB\MongoDBException
     */
    public function newGame(): Game
    {
        $game = new Game();
        $this->documentManger->persist($game);
        $this->documentManger->flush();

        return $game;
    }

    public function getGame(string $gameId): Game
    {
        /** @var Game $game */
        $game = $this->documentManger->getRepository(Game::class)->find($gameId);
        return $game;

    }

    /**
     * @param string $gameId
     * @param string $user
     * @param string $row
     * @param string $col
     * @return void
     * @throws GameNotFoundException
     * @throws \App\Domain\Exception\TrisMoveException
     * @throws \Doctrine\ODM\MongoDB\LockException
     * @throws \Doctrine\ODM\MongoDB\Mapping\MappingException
     * @throws \Doctrine\ODM\MongoDB\MongoDBException
     */
    public function move(string $gameId, string $user, string $row, string $col): Game
    {
        /** @var Game $game */
        $game = $this->documentManger->getRepository(Game::class)->find($gameId);

        $utils = new Utils();
        $coord = $utils->getCoordinates($row, $col);

        $this->gameValidator->validateMove($game, $user, $coord);

        if (!$game) {
            throw new GameNotFoundException('No game found for id ' . $gameId);
        }
        $game->addStep($user, $coord);
        $winner = $this->getWinner($game);
        $game->setWinner($winner);
        if (!empty($winner) || $game->hasReachedMaxMoves()) {
            $game->setAsClose();
        }
        $this->documentManger->persist($game);
        $this->documentManger->flush();
        return $game;
    }

    /**
     * @param Game $game
     * @return string|null
     */
    private function getWinner(Game $game): ?string
    {
        $user = null;
        if ($game->getStepNumbers() >= 5) {
            $arrayOfCoordToCheck = [
                ["0|0", "1|1", "2|2"], ["0|2", "1|1", "2|0"],//diagonal
                ["0|0", "0|1", "0|2"], ["1|0", "1|1", "1|2"], ["2|0", "2|1", "2|2"],//rows
                ["0|0", "1|0", "2|0"], ["0|1", "1|1", "2|1"], ["0|2", "1|2", "2|2"],//cols
            ];

            foreach ($arrayOfCoordToCheck as $coordToCheck){
                $user = $this->checkSameUser($game, $coordToCheck);

                if (!is_null($user)) {
                    break;
                }
            }
        }
        return $user;
    }


    private function checkSameUser(Game $game, array $coords): ?string
    {
        $users = [];
        foreach ($coords as $coord) {
            $users[] = $game->getUserByCoord($coord);
        }
        $unique = array_unique($users, SORT_STRING);
        if (count($unique) == 1) {
            return $unique[0];
        }

        return null;
    }


}
