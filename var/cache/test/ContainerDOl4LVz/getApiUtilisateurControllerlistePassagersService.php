<?php

namespace ContainerDOl4LVz;


use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getApiUtilisateurControllerlistePassagersService extends App_KernelTestDebugContainer
{
    /**
     * Gets the private '.service_locator.ncBLt3G.App\Controller\ApiUtilisateurController::listePassagers()' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.ncBLt3G.App\\Controller\\ApiUtilisateurController::listePassagers()'] = ($container->privates['.service_locator.ncBLt3G'] ?? $container->load('get_ServiceLocator_NcBLt3GService'))->withContext('App\\Controller\\ApiUtilisateurController::listePassagers()', $container);
    }
}
