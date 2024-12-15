<?php

namespace App\Tests\App;

use PHPUnit\Framework\TestCase;
use PHPUnit\TextUI\DefaultResultPrinter;

abstract class AbstractTainixTestCase extends TestCase implements TainixTestCaseInterface
{
    protected function assertSolveWithSampleData(): void
    {
        $challenge = new ($this->getChallengeClassName())();
        $data = new ($this->getSampleClassName())();
        $answer = $challenge->solve($data->inputs());

        $this->assertEquals($data->expected(), $answer);

        $printer = new DefaultResultPrinter();
        $printer->write(PHP_EOL.PHP_EOL.'Félicitations. Tu peux tenter de soumettre ton résultat avec la commande :');
        $printer->write(PHP_EOL.'bin/console tainix:solve '.$this->getChallengeCode());
    }
}
