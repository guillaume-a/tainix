<?php

namespace App\Tainix\Response;

use Symfony\Component\Serializer\Attribute\SerializedName;

final readonly class GameResponse
{
    #[SerializedName('game_message')]
    private string $message;
    #[SerializedName('game_success')]
    private bool $success;

    public function __construct(string $message, bool $success)
    {
        $this->message = $message;
        $this->success = $success;
    }

    public function getSuccess(): bool
    {
        return $this->success;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
