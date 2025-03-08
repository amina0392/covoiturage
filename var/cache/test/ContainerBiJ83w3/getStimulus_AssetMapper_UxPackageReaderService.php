<?php

namespace ContainerBiJ83w3;


use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getStimulus_AssetMapper_UxPackageReaderService extends App_KernelTestDebugContainer
{
    /**
     * Gets the private 'stimulus.asset_mapper.ux_package_reader' shared service.
     *
     * @return \Symfony\UX\StimulusBundle\Ux\UxPackageReader
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/symfony/stimulus-bundle/src/Ux/UxPackageReader.php';

        return $container->privates['stimulus.asset_mapper.ux_package_reader'] = new \Symfony\UX\StimulusBundle\Ux\UxPackageReader(\dirname(__DIR__, 4));
    }
}
