<?php

namespace App\Manager;

use App\Challenges\ChallengeInterface;

class ChallengeManager
{
    public function __construct(
        private array $challenges = [],
    ) {
    }

    public function addChallenge(string $code, ChallengeInterface $challenge)
    {
        $this->challenges[$code] = $challenge;
    }

    public function getChallenge(string $code): ChallengeInterface
    {
        if (!array_key_exists($code, $this->challenges)) {
            throw new \Exception(sprintf('Challenge with code %s not found.', $code));
        }

        return $this->challenges[$code];
    }
}
