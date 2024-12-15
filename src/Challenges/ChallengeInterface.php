<?php

namespace App\Challenges;

interface ChallengeInterface
{
    public const string SERVICE_TAG = 'tainix.challenge';

    public function solve(InputInterface $input): string;
}
