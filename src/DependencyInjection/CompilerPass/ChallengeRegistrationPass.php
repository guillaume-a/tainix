<?php

namespace App\DependencyInjection\CompilerPass;

use App\Challenges\ChallengeInterface;
use App\Manager\ChallengeManager;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\Reference;

class ChallengeRegistrationPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->has(ChallengeManager::class)) {
            return;
        }

        $definition = $container->findDefinition(ChallengeManager::class);
        $taggedServices = $container->findTaggedServiceIds(ChallengeInterface::SERVICE_TAG);

        foreach ($taggedServices as $id => $tags) {
            $def = $container->getDefinition($id);

            $class = $container->getParameterBag()->resolveValue($def->getClass());
            if (!is_subclass_of($class, ChallengeInterface::class)) {
                throw new InvalidArgumentException(\sprintf('Service "%s" must implement interface "%s".', $id, ChallengeInterface::class));
            }

            $definition->addMethodCall('addChallenge', [$tags[0]['code'], new Reference($id)]);
        }
    }
}
