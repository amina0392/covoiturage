<?php

namespace ContainerBiJ83w3;


use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getFragment_UriGeneratorService extends App_KernelTestDebugContainer
{
    /**
     * Gets the private 'fragment.uri_generator' shared service.
     *
     * @return \Symfony\Component\HttpKernel\Fragment\FragmentUriGenerator
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/symfony/http-kernel/Fragment/FragmentUriGeneratorInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/http-kernel/Fragment/FragmentUriGenerator.php';

        return $container->privates['fragment.uri_generator'] = new \Symfony\Component\HttpKernel\Fragment\FragmentUriGenerator('/_fragment', ($container->privates['uri_signer'] ?? $container->load('getUriSignerService')), ($container->services['request_stack'] ??= new \Symfony\Component\HttpFoundation\RequestStack()));
    }
}
