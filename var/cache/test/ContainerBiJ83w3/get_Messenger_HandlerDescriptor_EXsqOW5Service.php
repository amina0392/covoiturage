<?php

namespace ContainerBiJ83w3;


use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_Messenger_HandlerDescriptor_EXsqOW5Service extends App_KernelTestDebugContainer
{
    /**
     * Gets the private '.messenger.handler_descriptor.EXsqOW5' shared service.
     *
     * @return \Symfony\Component\Messenger\Handler\HandlerDescriptor
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/symfony/messenger/Handler/HandlerDescriptor.php';

        return $container->privates['.messenger.handler_descriptor.EXsqOW5'] = new \Symfony\Component\Messenger\Handler\HandlerDescriptor(($container->privates['texter.messenger.push_handler'] ?? $container->load('getTexter_Messenger_PushHandlerService')), []);
    }
}
