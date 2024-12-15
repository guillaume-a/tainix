<?php

namespace App\DependencyInjection\CompilerPass;

use App\Challenges\SampleInterface;
use App\Manager\SampleManager;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\Reference;

class SampleRegistrationPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->has(SampleManager::class)) {
            return;
        }

        $definition = $container->findDefinition(SampleManager::class);
        $taggedServices = $container->findTaggedServiceIds(SampleInterface::SERVICE_TAG);

        foreach ($taggedServices as $id => $tags) {
            $def = $container->getDefinition($id);

            $class = $container->getParameterBag()->resolveValue($def->getClass());
            if (!is_subclass_of($class, SampleInterface::class)) {
                throw new InvalidArgumentException(\sprintf('Service "%s" must implement interface "%s".', $id, SampleInterface::class));
            }

            $definition->addMethodCall('addSample', [$tags[0]['code'], new Reference($id)]);
        }
    }
}
