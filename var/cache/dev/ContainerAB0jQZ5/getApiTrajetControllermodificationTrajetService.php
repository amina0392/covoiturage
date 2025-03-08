<?php

namespace ContainerAB0jQZ5;


use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getApiTrajetControllermodificationTrajetService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.PgTpCNB.App\Controller\ApiTrajetController::modificationTrajet()' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.PgTpCNB.App\\Controller\\ApiTrajetController::modificationTrajet()'] = (new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService ??= $container->getService(...), [
            'trajetRepo' => ['privates', 'App\\Repository\\TrajetRepository', 'getTrajetRepositoryService', true],
            'entityManager' => ['services', 'doctrine.orm.default_entity_manager', 'getDoctrine_Orm_DefaultEntityManagerService', false],
            'utilisateurRepo' => ['privates', 'App\\Repository\\UtilisateurRepository', 'getUtilisateurRepositoryService', true],
            'villeRepo' => ['privates', 'App\\Repository\\VilleRepository', 'getVilleRepositoryService', true],
        ], [
            'trajetRepo' => 'App\\Repository\\TrajetRepository',
            'entityManager' => '?',
            'utilisateurRepo' => 'App\\Repository\\UtilisateurRepository',
            'villeRepo' => 'App\\Repository\\VilleRepository',
        ]))->withContext('App\\Controller\\ApiTrajetController::modificationTrajet()', $container);
    }
}
