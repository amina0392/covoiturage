<?php

namespace ContainerBiJ83w3;


use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getApiReservationControllergetReservationService extends App_KernelTestDebugContainer
{
    /**
     * Gets the private '.service_locator.ncBLt3G.App\Controller\ApiReservationController::getReservation()' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.ncBLt3G.App\\Controller\\ApiReservationController::getReservation()'] = ($container->privates['.service_locator.ncBLt3G'] ?? $container->load('get_ServiceLocator_NcBLt3GService'))->withContext('App\\Controller\\ApiReservationController::getReservation()', $container);
    }
}
