<?php

namespace ContainerBiJ83w3;


use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getAssetMapper_Importmap_AuditorService extends App_KernelTestDebugContainer
{
    /**
     * Gets the private 'asset_mapper.importmap.auditor' shared service.
     *
     * @return \Symfony\Component\AssetMapper\ImportMap\ImportMapAuditor
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/symfony/asset-mapper/ImportMap/ImportMapAuditor.php';

        return $container->privates['asset_mapper.importmap.auditor'] = new \Symfony\Component\AssetMapper\ImportMap\ImportMapAuditor(($container->privates['asset_mapper.importmap.config_reader'] ?? $container->load('getAssetMapper_Importmap_ConfigReaderService')), ($container->privates['.debug.http_client'] ?? self::get_Debug_HttpClientService($container)));
    }
}
