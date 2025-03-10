<?php

namespace ContainerAB0jQZ5;


use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getApiUtilisateurControllersuppressionUtilisateurService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.btnzUaD.App\Controller\ApiUtilisateurController::suppressionUtilisateur()' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.btnzUaD.App\\Controller\\ApiUtilisateurController::suppressionUtilisateur()'] = (new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService ??= $container->getService(...), [
            'entityManager' => ['services', 'doctrine.orm.default_entity_manager', 'getDoctrine_Orm_DefaultEntityManagerService', false],
            'utilisateurRepo' => ['privates', 'App\\Repository\\UtilisateurRepository', 'getUtilisateurRepositoryService', true],
            'security' => ['privates', 'security.helper', 'getSecurity_HelperService', true],
        ], [
            'entityManager' => '?',
            'utilisateurRepo' => 'App\\Repository\\UtilisateurRepository',
            'security' => '?',
        ]))->withContext('App\\Controller\\ApiUtilisateurController::suppressionUtilisateur()', $container);
    }
}
