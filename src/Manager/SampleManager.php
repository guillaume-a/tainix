<?php

namespace App\Manager;

use App\Challenges\SampleInterface;

class SampleManager
{
    public function __construct(
        private array $samples = [],
    ) {
    }

    public function addSample(string $code, SampleInterface $sample)
    {
        $this->samples[$code] = $sample;
    }

    public function getSample(string $code): SampleInterface
    {
        if (!array_key_exists($code, $this->samples)) {
            throw new \Exception(sprintf('Sample for code %s not found.', $code));
        }

        return $this->samples[$code];
    }
}
