<?php

namespace App\Attribute;

#[\Attribute(\Attribute::TARGET_CLASS)]
readonly class AsSample
{
    public function __construct(
        public string $code,
    ) {
    }
}
