<?php

namespace App\Maker;

use App\Attribute\AsChallenge;
use App\Attribute\AsGame;
use App\Attribute\AsSample;
use App\Challenges\ChallengeInterface;
use App\Challenges\GameInterface;
use App\Challenges\SampleInterface;
use App\Tainix\Api;
use App\Tests\App\AbstractTainixTestCase;
use Symfony\Bundle\MakerBundle\ConsoleStyle;
use Symfony\Bundle\MakerBundle\DependencyBuilder;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Bundle\MakerBundle\Maker\AbstractMaker;
use Symfony\Bundle\MakerBundle\Util\ClassNameDetails;
use Symfony\Bundle\MakerBundle\Util\UseStatementGenerator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;

use function Symfony\Component\String\u;

abstract class AbstractMakeTainix extends AbstractMaker implements MakeTainixInterface
{
    protected string $challengeCode;
    protected Generator $generator;
    /** @var ClassNameDetails[] */
    protected array $classNameDetails = [];

    public function __construct(
        private readonly Api $api,
    ) {
    }

    public function configureCommand(
        Command $command,
        InputConfiguration $inputConfig,
    ): void {
        $command
            ->addArgument('code', InputArgument::OPTIONAL, 'Choose a challenge code (e.g. <fg=yellow>PIERRE_FEUILLE_CISEAUX</>)')
        ;
    }

    public function configureDependencies(DependencyBuilder $dependencies)
    {
    }

    protected function getNamespacePrefix(string $dir = ''): string
    {
        return 'Challenges\\'.$this->challengeCode.'\\'.('' !== $dir ? $dir.'\\' : '');
    }

    public function generate(
        InputInterface $input,
        ConsoleStyle $io,
        Generator $generator,
    ): void {
        $this->challengeCode = trim($input->getArgument('code'));
        $this->generator = $generator;

        foreach ($this->getGenerators() as $callable) {
            $callable();
        }

        $generator->writeChanges();

        $this->writeSuccessMessage($io);

        $this->finished($io);
    }

    protected function getClassNameDetails(string $className, string $dir = ''): ClassNameDetails
    {
        if (array_key_exists($className, $this->classNameDetails)) {
            return $this->classNameDetails[$className];
        }

        $this->classNameDetails[$className] = $this->generator->createClassNameDetails(
            $className,
            $this->getNamespacePrefix($dir),
        );

        return $this->classNameDetails[$className];
    }

    protected function generateInput(): void
    {
        $sample = $this->api->loadSample($this->challengeCode);

        $useStatements = new UseStatementGenerator([
            \App\Challenges\InputInterface::class,
        ]);

        $this->generator->generateClass(
            $this->getClassNameDetails('Input', 'Tainix')->getFullName(),
            __DIR__.'/../Resources/skeleton/tainix/Input.tpl.php',
            [
                'use_statements' => $useStatements,
                'keys' => array_keys($sample->getInput()),
            ]
        );
    }

    protected function generateSample(): void
    {
        $sample = $this->api->loadSample($this->challengeCode);

        $useStatements = new UseStatementGenerator([
            SampleInterface::class,
            AsSample::class,
            \App\Challenges\InputInterface::class,
            $this->getClassNameDetails('Input', 'Tainix')->getFullName(),
        ]);

        $this->generator->generateClass(
            $this->getClassNameDetails('Sample', 'Tainix')->getFullName(),
            __DIR__.'/../Resources/skeleton/tainix/Sample.tpl.php',
            [
                'use_statements' => $useStatements,
                'challenge_code' => $this->challengeCode,
                'input_class' => $this->getClassNameDetails('Input', 'Tainix')->getShortName(),
                'inputs' => $sample->getInput(),
                'expected' => $sample->getExpected(),
            ]
        );
    }

    protected function generateChallenge(): void
    {
        $useStatements = new UseStatementGenerator([
            ChallengeInterface::class,
            AsChallenge::class,
            \App\Challenges\InputInterface::class,
            $this->getClassNameDetails('Input', 'Tainix')->getFullName(),
        ]);

        $this->generator->generateClass(
            $this->getClassNameDetails('Challenge')->getFullName(),
            __DIR__.'/../Resources/skeleton/tainix/Challenge.tpl.php',
            [
                'use_statements' => $useStatements,
                'input_class_name' => $this->getClassNameDetails('Input', 'Tainix')->getShortName(),
                'challenge_code' => $this->challengeCode,
            ]
        );
    }

    protected function generateGame(): void
    {
        $game = $this->api->gameStart($this->challengeCode);

        $useStatements = new UseStatementGenerator([
            GameInterface::class,
            AsGame::class,
            \App\Challenges\InputInterface::class,
        ]);

        $this->generator->generateClass(
            $this->getClassNameDetails('Game', 'Tainix')->getFullName(),
            __DIR__.'/../Resources/skeleton/tainix/Game.tpl.php',
            [
                'use_statements' => $useStatements,
                'challenge_code' => $this->challengeCode,
                'input_class' => $this->getClassNameDetails('Input', 'Tainix')->getShortName(),
                'inputs' => $game->getInput(),
                'token' => $game->getToken(),
            ]
        );
    }

    protected function generateTest(): void
    {
        $classNameDetails = $this->generator->createClassNameDetails(
            u($this->challengeCode)->lower()->camel()->title(),
            'Tests\\Challenges',
            'Test'
        );

        $useStatements = new UseStatementGenerator([
            $this->getClassNameDetails('Challenge')->getFullName(),
            $this->getClassNameDetails('Sample', 'Tainix')->getFullName(),
            AbstractTainixTestCase::class,
        ]);

        $this->generator->generateClass(
            $classNameDetails->getFullName(),
            __DIR__.'/../Resources/skeleton/tainix/Test.tpl.php',
            [
                'use_statements' => $useStatements,
                'challenge_code' => $this->challengeCode,
                'challenge_class' => $this->getClassNameDetails('Challenge')->getShortName(),
                'sample_class' => $this->getClassNameDetails('Sample', 'Tainix')->getShortName(),
            ]
        );
    }
}
