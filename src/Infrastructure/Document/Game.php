<?php

namespace App\Infrastructure\Document;

use App\Domain\Model\GameConstants;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

#[MongoDB\Document(db: "tris", collection: "games")]
class Game
{
    #[MongoDB\Id(strategy: "UUID")]
    protected string $gameId;

    #[MongoDB\Field(type: "hash")]
    protected array $steps = [];

    #[MongoDB\Field(type: "string")]
    protected ?string $winner;

    #[MongoDB\Field(type: "string")]
    protected string $status = "open";


    public function __construct()
    {
        $this->steps = [];
    }


    /**
     * @return array
     */
    public function getSteps(): array
    {
        return $this->steps;
    }

    /**
     * @param array $steps
     */
    public function setSteps(array $steps): void
    {
        $this->steps = $steps;
    }

    /**
     * @param string $user
     * @param string $coord
     * @return void
     */
    public function addStep(string $user, string $coord): void
    {
        $this->steps[$coord] = $user;
    }

    /**
     * return the user that made a move for the specific coordinates
     *
     * @param string $coord
     * @return string|null
     */
    public function getUserByCoord(string $coord): ?string
    {
        if($this->existsStep($coord)) {
            return $this->steps[$coord];
        }
        return null;
    }

    /**
     * @param string $coord
     * @return bool
     */
    public function existsStep(string $coord): bool
    {
        return array_key_exists($coord,$this->getSteps());
    }

    /**
     * @return string
     */
    public function getGameId(): string
    {
        return $this->gameId;
    }

    /**
     * @param string $gameId
     */
    public function setGameId(string $gameId): void
    {
        $this->gameId = $gameId;
    }


    /**
     * @return string|null
     */
    public function getWinner(): ?string
    {
        return $this->winner;
    }

    /**
     * @param string|null $winner
     * @return void
     */
    public function setWinner(?string $winner): void
    {
        $this->winner = $winner;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return bool
     */
    public function isOpen(): bool
    {
        return $this->status == "open";
    }

    /**
     * @return void
     */
    public function setAsClose():void
    {
        $this->setStatus("close");
    }

    /**
     * @return bool
     */
    public function hasReachedMaxMoves(): bool{
        return ($this->getStepNumbers() == GameConstants::MAX_MOVES);
    }

    /**
     * @return int
     */
    public function getStepNumbers():int
    {
        return count($this->getSteps());
    }
}
