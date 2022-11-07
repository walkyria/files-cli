#!/usr/bin/env php
<?php

use Symfony\Component\Console\Application;

require_once __DIR__ . '/../vendor/autoload.php';

class App extends Application
{

    public function __construct(iterable $commands)
    {
        $commands = $commands instanceof Traversable ? iterator_to_array($commands) : $commands;

        foreach ($commands as $command) {
            $this->add($command);
        }

        parent::__construct();
    }
}

$container = new Symfony\Component\DependencyInjection\ContainerBuilder();
$loader    = new Symfony\Component\DependencyInjection\Loader\YamlFileLoader($container, new Symfony\Component\Config\FileLocator(__DIR__ . '/../config'));

try {
    $loader->load('services.yaml');
} catch (Exception $e) {
    var_dump($e->getMessage());
}
$container->compile();

try {
    $app = $container->get(App::class);
} catch (Exception $e) {
    var_dump($e->getMessage());
}
$app->run();
