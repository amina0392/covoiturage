<?php

namespace ContainerBiJ83w3;


use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getApiVoitureControllersuppressionVoitureService extends App_KernelTestDebugContainer
{
    /**
     * Gets the private '.service_locator.GDVkKA8.App\Controller\ApiVoitureController::suppressionVoiture()' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.GDVkKA8.App\\Controller\\ApiVoitureController::suppressionVoiture()'] = (new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService ??= $container->getService(...), [
            'entityManager' => ['services', 'doctrine.orm.default_entity_manager', 'getDoctrine_Orm_DefaultEntityManagerService', false],
            'security' => ['privates', 'security.helper', 'getSecurity_HelperService', true],
        ], [
            'entityManager' => '?',
            'security' => '?',
        ]))->withContext('App\\Controller\\ApiVoitureController::suppressionVoiture()', $container);
    }
}
