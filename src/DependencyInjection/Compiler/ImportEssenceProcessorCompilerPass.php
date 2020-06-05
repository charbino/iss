<?php


namespace App\DependencyInjection\Compiler;


use App\Import\ImportProcessorChaining;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class ImportEssenceProcessorCompilerPass
 *
 * @package App\DependencyInjection\Compiler
 *
 * @author  Sébatien Framinet <sebastien.framinet@asdoria.com>
 *
 */
class ImportEssenceProcessorCompilerPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $importerDefinition = $container->getDefinition(ImportProcessorChaining::class);
        $this->addServices(
            $container,
            $importerDefinition,
            'importer.essence.processor',
            'add'
        );
    }


    /**
     * @param ContainerBuilder $container
     * @param Definition       $definition
     * @param string           $tagName
     * @param string           $method
     * @param string           $arg
     */
    protected function addServices(ContainerBuilder $container, Definition $definition, string $tagName, string $method, $arg = 'priority') :void {
        foreach ($container->findTaggedServiceIds($tagName) as $serviceId => $tags) {
            $priority = @$tags[0][$arg] ?? 0;
            $definition->addMethodCall(
                $method,
                [new Reference($serviceId), $priority]
            );
        }
    }
}
