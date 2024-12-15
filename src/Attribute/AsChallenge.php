<?php

namespace App\Attribute;

#[\Attribute(\Attribute::TARGET_CLASS)]
readonly class AsChallenge
{
    public function __construct(
        public string $code,
    ) {
    }
}
