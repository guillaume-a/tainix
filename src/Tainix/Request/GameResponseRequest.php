<?php

namespace App\Tainix\Request;

final readonly class GameResponseRequest
{
    public function __construct(
        public string $data,
    ) {
    }
}
