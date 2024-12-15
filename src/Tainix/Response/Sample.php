<?php

namespace App\Tainix\Response;

use Symfony\Component\Serializer\Attribute\SerializedPath;

final readonly class Sample
{
    #[SerializedPath('[sample][input_data]')]
    private array $input;
    #[SerializedPath('[sample][correct_response]')]
    private string|int $expected;

    public function __construct(array $input, string $expected)
    {
        $this->input = $input;
        $this->expected = $expected;
    }

    public function getInput(): array
    {
        return $this->input;
    }

    public function getExpected(): string|int
    {
        return (string) $this->expected;
    }
}
