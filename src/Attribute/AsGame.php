<?php

namespace App\Attribute;

#[\Attribute(\Attribute::TARGET_CLASS)]
readonly class AsGame
{
    public function __construct(
        public string $code,
    ) {
    }
}
