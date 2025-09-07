<?php

namespace App\Domain\Model;

class Game {
    protected string $gameId;
    protected array $stepHistory = [];
    protected ?string $winner;
    protected string $status = "open";
//$initialDate=Carbon.now();

    public function __construct(string $gameId)
    {
    }


    /**
     * @return array
     */
    public function getStephistory(): array
    {
        return $this->stepHistory;
    }

    /**
     * @param array $stepHistory
     */
    public function setStephistory(array $stepHistory): void
    {
        $this->stepHistory = $stepHistory;
    }

    /**
     * @param string $user
     * @param string $coord
     * @return void
     */
    public function addStep(string $user, string $coord): void
    {
        $this->stepHistory[$coord] = $user;
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
            return $this->stepHistory[$coord];
        }
        return null;
    }

    /**
     * @param string $coord
     * @return bool
     */
    public function existsStep(string $coord): bool
    {
        return array_key_exists($coord,$this->getStephistory());
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
        return count($this->getStephistory());
    }
}
