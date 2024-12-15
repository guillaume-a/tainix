<?php

namespace App\Tainix\Response;

final readonly class GameStart
{
    private array $input;
    private string $token;

    public function __construct(array $input, string $token)
    {
        $this->input = $input;
        $this->token = $token;
    }

    public function getInput(): array
    {
        return $this->input;
    }

    public function getToken(): string
    {
        return $this->token;
    }
}
