<?php

namespace App\Challenges;

interface GameInterface
{
    public const string SERVICE_TAG = 'tainix.game';

    public function inputs(): InputInterface;

    public function token(): string;
}
