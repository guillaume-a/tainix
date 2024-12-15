<?php

namespace App;

use App\Attribute\AsChallenge;
use App\Attribute\AsGame;
use App\Attribute\AsSample;
use App\Challenges\ChallengeInterface;
use App\Challenges\GameInterface;
use App\Challenges\SampleInterface;
use App\DependencyInjection\CompilerPass\ChallengeRegistrationPass;
use App\DependencyInjection\CompilerPass\GameRegistrationPass;
use App\DependencyInjection\CompilerPass\SampleRegistrationPass;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    protected function build(ContainerBuilder $container): void
    {
        $container->registerAttributeForAutoconfiguration(
            AsChallenge::class,
            static function (ChildDefinition $definition, AsChallenge $attribute) {
                $tagAttributes = get_object_vars($attribute);
                $definition->addTag(ChallengeInterface::SERVICE_TAG, $tagAttributes);
            }
        );

        $container->registerAttributeForAutoconfiguration(
            AsSample::class,
            static function (ChildDefinition $definition, AsSample $attribute) {
                $tagAttributes = get_object_vars($attribute);
                $definition->addTag(SampleInterface::SERVICE_TAG, $tagAttributes);
            }
        );

        $container->registerAttributeForAutoconfiguration(
            AsGame::class,
            static function (ChildDefinition $definition, AsGame $attribute) {
                $tagAttributes = get_object_vars($attribute);
                $definition->addTag(GameInterface::SERVICE_TAG, $tagAttributes);
            }
        );

        $container->addCompilerPass(new ChallengeRegistrationPass());
        $container->addCompilerPass(new SampleRegistrationPass());
        $container->addCompilerPass(new GameRegistrationPass());
    }
}
