<?php

namespace ContainerXRRDY0B;


use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getApiReservationControllerconfirmerReservationService extends App_KernelTestDebugContainer
{
    /**
     * Gets the private '.service_locator.MpimfDU.App\Controller\ApiReservationController::confirmerReservation()' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        $a = ($container->privates['.service_locator.MpimfDU'] ?? $container->load('get_ServiceLocator_MpimfDUService'));

        if (isset($container->privates['.service_locator.MpimfDU.App\\Controller\\ApiReservationController::confirmerReservation()'])) {
            return $container->privates['.service_locator.MpimfDU.App\\Controller\\ApiReservationController::confirmerReservation()'];
        }

        return $container->privates['.service_locator.MpimfDU.App\\Controller\\ApiReservationController::confirmerReservation()'] = $a->withContext('App\\Controller\\ApiReservationController::confirmerReservation()', $container);
    }
}
