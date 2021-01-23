<?php

declare(strict_types=1);

namespace App\DependencyInjection\Compiler;

use App\Mail\TransportChain;
use App\Reader\FileReader;
use App\Service\MainFileReader;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class AppCompiler implements CompilerPassInterface
{
    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has(MainFileReader::class)) {
            return;
        }

        $definition = $container->findDefinition(MainFileReader::class);
        $services = $container->findTaggedServiceIds('app.file_reader');

//        dd($services);
        foreach ($services as $id => $tags) {
            foreach ($tags as $tag) {
                $definition->addMethodCall('addReader', [
                    new Reference($id),
                    $tag['alias']
                ]);
            }
        }
    }
}
