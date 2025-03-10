<?php

namespace ContainerDOl4LVz;


use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getSecurity_Firewall_Map_Context_InscriptionService extends App_KernelTestDebugContainer
{
    /**
     * Gets the private 'security.firewall.map.context.inscription' shared service.
     *
     * @return \Symfony\Bundle\SecurityBundle\Security\FirewallContext
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/symfony/security-bundle/Security/FirewallContext.php';

        return $container->privates['security.firewall.map.context.inscription'] = new \Symfony\Bundle\SecurityBundle\Security\FirewallContext(new RewindableGenerator(fn () => new \EmptyIterator(), 0), NULL, NULL, ($container->privates['security.firewall.map.config.inscription'] ?? $container->load('getSecurity_Firewall_Map_Config_InscriptionService')));
    }
}
