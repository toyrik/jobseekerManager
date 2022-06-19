<?php

namespace App\Container;

use App\Twig\Extension\Processor\ProcessorExtension;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ProcessorCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $definition = $container->findDefinition(ProcessorExtension::class);

        $services = $container->findTaggedServiceIds('app.twig.vacancy_processor.driver');

        $references = [];
        foreach ($services as $id => $attributes) {
            $references[] = new Reference($id);
        }

        $definition->setArgument(0, $references);
    }
}
