<?php

namespace ContainerXRRDY0B;


use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getSecurity_Firewall_Map_Config_ApiService extends App_KernelTestDebugContainer
{
    /**
     * Gets the private 'security.firewall.map.config.api' shared service.
     *
     * @return \Symfony\Bundle\SecurityBundle\Security\FirewallConfig
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/symfony/security-bundle/Security/FirewallConfig.php';

        return $container->privates['security.firewall.map.config.api'] = new \Symfony\Bundle\SecurityBundle\Security\FirewallConfig('api', 'security.user_checker', '.security.request_matcher.NaFk5J1', true, true, 'security.user.provider.concrete.app_user_provider', NULL, 'security.authenticator.jwt.api', NULL, NULL, ['jwt'], NULL, NULL);
    }
}
