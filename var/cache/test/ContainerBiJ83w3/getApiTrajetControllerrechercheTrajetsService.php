<?php

namespace ContainerBiJ83w3;


use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getApiTrajetControllerrechercheTrajetsService extends App_KernelTestDebugContainer
{
    /**
     * Gets the private '.service_locator.dlWO762.App\Controller\ApiTrajetController::rechercheTrajets()' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.dlWO762.App\\Controller\\ApiTrajetController::rechercheTrajets()'] = ($container->privates['.service_locator.dlWO762'] ?? $container->load('get_ServiceLocator_DlWO762Service'))->withContext('App\\Controller\\ApiTrajetController::rechercheTrajets()', $container);
    }
}
