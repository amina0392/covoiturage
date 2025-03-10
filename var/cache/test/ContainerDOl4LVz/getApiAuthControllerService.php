<?php

namespace ContainerDOl4LVz;


use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getApiAuthControllerService extends App_KernelTestDebugContainer
{
    /**
     * Gets the public 'App\Controller\ApiAuthController' shared autowired service.
     *
     * @return \App\Controller\ApiAuthController
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/symfony/framework-bundle/Controller/AbstractController.php';
        include_once \dirname(__DIR__, 4).'/src/Controller/ApiAuthController.php';

        $container->services['App\\Controller\\ApiAuthController'] = $instance = new \App\Controller\ApiAuthController();

        $instance->setContainer(($container->privates['.service_locator.ZyP9f7K'] ?? $container->load('get_ServiceLocator_ZyP9f7KService'))->withContext('App\\Controller\\ApiAuthController', $container));

        return $instance;
    }
}
