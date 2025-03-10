<?php

namespace ContainerDOl4LVz;


use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getApiReservationControllerService extends App_KernelTestDebugContainer
{
    /**
     * Gets the public 'App\Controller\ApiReservationController' shared autowired service.
     *
     * @return \App\Controller\ApiReservationController
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/symfony/framework-bundle/Controller/AbstractController.php';
        include_once \dirname(__DIR__, 4).'/src/Controller/ApiReservationController.php';

        $container->services['App\\Controller\\ApiReservationController'] = $instance = new \App\Controller\ApiReservationController();

        $instance->setContainer(($container->privates['.service_locator.ZyP9f7K'] ?? $container->load('get_ServiceLocator_ZyP9f7KService'))->withContext('App\\Controller\\ApiReservationController', $container));

        return $instance;
    }
}
