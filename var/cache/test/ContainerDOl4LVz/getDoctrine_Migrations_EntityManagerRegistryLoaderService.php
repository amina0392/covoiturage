<?php

namespace ContainerDOl4LVz;


use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getDoctrine_Migrations_EntityManagerRegistryLoaderService extends App_KernelTestDebugContainer
{
    /**
     * Gets the private 'doctrine.migrations.entity_manager_registry_loader' shared service.
     *
     * @return \Doctrine\Migrations\Configuration\EntityManager\ManagerRegistryEntityManager
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/migrations/src/Configuration/EntityManager/EntityManagerLoader.php';
        include_once \dirname(__DIR__, 4).'/vendor/doctrine/migrations/src/Configuration/EntityManager/ManagerRegistryEntityManager.php';

        return $container->privates['doctrine.migrations.entity_manager_registry_loader'] = \Doctrine\Migrations\Configuration\EntityManager\ManagerRegistryEntityManager::withSimpleDefault(($container->services['doctrine'] ?? self::getDoctrineService($container)));
    }
}
