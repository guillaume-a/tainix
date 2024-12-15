<?php

namespace App\Challenges;

interface SampleInterface
{
    public const string SERVICE_TAG = 'tainix.sample';

    public function inputs(): InputInterface;

    public function expected(): string;
}
