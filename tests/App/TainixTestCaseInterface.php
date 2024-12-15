<?php

namespace App\Tests\App;

interface TainixTestCaseInterface
{
    public function getChallengeClassName(): string;

    public function getSampleClassName(): string;

    public function getChallengeCode(): string;
}
