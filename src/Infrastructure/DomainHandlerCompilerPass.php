<?php


namespace App\Infrastructure;


use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class DomainHandlerCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if ( ! $container->has(DomainEventDispatcher::class)) {
            return;
        }

        $definition = $container->findDefinition(DomainEventDispatcher::class);

        $domainEventHandlers = $container->findTaggedServiceIds('app.domain_event_handler');

        foreach ($domainEventHandlers as $id => $tags) {
            // Add handler to dispatcher
            $definition->addMethodCall('addHandler', array(new Reference($id)));
        }
    }
}