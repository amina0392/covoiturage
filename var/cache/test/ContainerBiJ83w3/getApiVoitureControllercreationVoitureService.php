<?php

namespace ContainerBiJ83w3;


use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getApiVoitureControllercreationVoitureService extends App_KernelTestDebugContainer
{
    /**
     * Gets the private '.service_locator.V4sjxsM.App\Controller\ApiVoitureController::creationVoiture()' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.V4sjxsM.App\\Controller\\ApiVoitureController::creationVoiture()'] = (new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService ??= $container->getService(...), [
            'entityManager' => ['services', 'doctrine.orm.default_entity_manager', 'getDoctrine_Orm_DefaultEntityManagerService', false],
            'validator' => ['privates', 'debug.validator', 'getDebug_ValidatorService', false],
            'utilisateurRepo' => ['privates', 'App\\Repository\\UtilisateurRepository', 'getUtilisateurRepositoryService', true],
        ], [
            'entityManager' => '?',
            'validator' => '?',
            'utilisateurRepo' => 'App\\Repository\\UtilisateurRepository',
        ]))->withContext('App\\Controller\\ApiVoitureController::creationVoiture()', $container);
    }
}
