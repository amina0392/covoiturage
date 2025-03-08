<?php

namespace ContainerAB0jQZ5;


use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getDebug_Security_Authenticator_Jwt_ApiService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private 'debug.security.authenticator.jwt.api' shared service.
     *
     * @return \Symfony\Component\Security\Http\Authenticator\Debug\TraceableAuthenticator
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/symfony/security-http/Authenticator/AuthenticatorInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/security-http/Authenticator/InteractiveAuthenticatorInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/security-http/EntryPoint/AuthenticationEntryPointInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/security-http/Authenticator/Debug/TraceableAuthenticator.php';

        $a = ($container->privates['security.authenticator.jwt.api'] ?? $container->load('getSecurity_Authenticator_Jwt_ApiService'));

        if (isset($container->privates['debug.security.authenticator.jwt.api'])) {
            return $container->privates['debug.security.authenticator.jwt.api'];
        }

        return $container->privates['debug.security.authenticator.jwt.api'] = new \Symfony\Component\Security\Http\Authenticator\Debug\TraceableAuthenticator($a);
    }
}
