<?php

namespace App\Maker;

use Symfony\Bundle\MakerBundle\ConsoleStyle;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Component\Console\Command\Command;

final class MakeChallenge extends AbstractMakeTainix
{
    public static function getCommandName(): string
    {
        return 'make:tainix:challenge';
    }

    public static function getCommandDescription(): string
    {
        return 'Create new files to start a tainix challenge.';
    }

    public function configureCommand(
        Command $command,
        InputConfiguration $inputConfig,
    ): void {
        parent::configureCommand($command, $inputConfig);

        $command
            ->setHelp(file_get_contents(__DIR__.'/../Resources/help/MakeChallenge.txt'))
        ;
    }

    public function getGenerators(): array
    {
        return [
            [$this, 'generateChallenge'],
            [$this, 'generateInput'],
            [$this, 'generateSample'],
            [$this, 'generateGame'],
            [$this, 'generateTest'],
        ];
    }

    public function finished(ConsoleStyle $io): void
    {
        $io->text([
            'Next: open your challenge class and solve it !',
        ]);
    }
}
