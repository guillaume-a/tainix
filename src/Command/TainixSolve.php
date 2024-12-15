<?php

namespace App\Command;

use App\Manager\ChallengeManager;
use App\Manager\GameManager;
use App\Tainix\Api;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'tainix:solve',
    description: 'Execute this command to post your result.',
)]
class TainixSolve extends Command
{
    public function __construct(
        private readonly ChallengeManager $challengeManager,
        private readonly GameManager $gameManager,
        private readonly Api $api,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('code', InputArgument::REQUIRED, 'Tainix challenge\'s code.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $code = $input->getArgument('code');

        $this->api->gameStart($code);

        $challenge = $this->challengeManager->getChallenge($code);
        $data = $this->gameManager->getGame($code);

        $answer = $challenge->solve($data->inputs());

        $gameResponse = $this->api->gameResponse($data->token(), $answer);

        if (!$gameResponse->getSuccess()) {
            $io->error($gameResponse->getMessage());

            return Command::FAILURE;
        }

        $io->success($gameResponse->getMessage());
        $io->success('https://tainix.fr/games/story/'.$data->token());

        return Command::SUCCESS;
    }
}
