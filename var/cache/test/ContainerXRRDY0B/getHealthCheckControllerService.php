<?php

namespace ContainerXRRDY0B;


use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getHealthCheckControllerService extends App_KernelTestDebugContainer
{
    /**
     * Gets the public 'App\Controller\HealthCheckController' shared autowired service.
     *
     * @return \App\Controller\HealthCheckController
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/symfony/framework-bundle/Controller/AbstractController.php';
        include_once \dirname(__DIR__, 4).'/src/Controller/HealthCheckController.php';

        $container->services['App\\Controller\\HealthCheckController'] = $instance = new \App\Controller\HealthCheckController();

        $instance->setContainer(($container->privates['.service_locator.ZyP9f7K'] ?? $container->load('get_ServiceLocator_ZyP9f7KService'))->withContext('App\\Controller\\HealthCheckController', $container));

        return $instance;
    }
}
