<?php

namespace App\Manager;

use App\Challenges\GameInterface;

class GameManager
{
    public function __construct(
        private array $games = [],
    ) {
    }

    public function addGame(string $code, GameInterface $sample)
    {
        $this->games[$code] = $sample;
    }

    public function getGame(string $code): GameInterface
    {
        if (!array_key_exists($code, $this->games)) {
            throw new \Exception(sprintf('Game data for code %s not found.', $code));
        }

        return $this->games[$code];
    }
}
