<?php

namespace App\Maker;

use Symfony\Bundle\MakerBundle\ConsoleStyle;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Component\Console\Command\Command;

final class MakeReset extends AbstractMakeTainix
{
    public static function getCommandName(): string
    {
        return 'make:tainix:reset';
    }

    public static function getCommandDescription(): string
    {
        return 'Reset game data for a tainix challenge.';
    }

    public function configureCommand(
        Command $command,
        InputConfiguration $inputConfig,
    ): void {
        parent::configureCommand($command, $inputConfig);

        $command
            ->setHelp(file_get_contents(__DIR__.'/../Resources/help/MakeReset.txt'))
        ;
    }

    public function getGenerators(): array
    {
        return [
            [$this, 'deleteGame'],
            [$this, 'generateGame'],
        ];
    }

    public function finished(ConsoleStyle $io): void
    {
        $io->text([
            'Next: open your challenge class and solve it !',
        ]);
    }

    protected function deleteGame(): void
    {
        $gameClassNameDetails = $this->getClassNameDetails('Game', 'Tainix');
        if (!class_exists($gameClassNameDetails->getFullName())) {
            return;
        }

        unlink(__DIR__.'/../Challenges/'.$this->challengeCode.'/Tainix/Game.php');
    }
}
