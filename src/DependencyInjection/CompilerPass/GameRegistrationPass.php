<?php

namespace App\DependencyInjection\CompilerPass;

use App\Challenges\GameInterface;
use App\Manager\GameManager;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\Reference;

class GameRegistrationPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->has(GameManager::class)) {
            return;
        }

        $definition = $container->findDefinition(GameManager::class);
        $taggedServices = $container->findTaggedServiceIds(GameInterface::SERVICE_TAG);

        foreach ($taggedServices as $id => $tags) {
            $def = $container->getDefinition($id);

            $class = $container->getParameterBag()->resolveValue($def->getClass());
            if (!is_subclass_of($class, GameInterface::class)) {
                throw new InvalidArgumentException(\sprintf('Service "%s" must implement interface "%s".', $id, GameInterface::class));
            }

            $definition->addMethodCall('addGame', [$tags[0]['code'], new Reference($id)]);
        }
    }
}
