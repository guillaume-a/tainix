<?php

namespace App\Maker;

use Symfony\Bundle\MakerBundle\ConsoleStyle;

interface MakeTainixInterface
{
    /** @return callable[] */
    public function getGenerators(): array;

    public function finished(ConsoleStyle $io): void;
}
