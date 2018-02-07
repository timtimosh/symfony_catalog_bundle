<?php

namespace Mtt\CatalogBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class MttCatalogExtension extends Extension implements PrependExtensionInterface, CompilerPassInterface
{
    public function load(array $configs, ContainerBuilder $container){

    }

    public function prepend(ContainerBuilder $container)
    {
        $configs = $container->getExtensionConfig($this->getAlias());
        $myBundleConfig = $this->processConfiguration(new Configuration(), $configs);

        $container->setParameter('mtt_catalog.product_entity', $myBundleConfig['product_entity']);
        $container->setParameter('mtt_catalog.category_entity', $myBundleConfig['category_entity']);
        $container->setParameter('mtt_catalog.characteristic_entity', $myBundleConfig['characteristic_entity']);
        $container->setParameter('mtt_catalog.characteristic_value_entity', $myBundleConfig['characteristic_value_entity']);

        if(!empty($myBundleConfig['easy_admin_integration'])) {
            $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../EasyAdminIntegration/Resources/config'));
            $loader->load('superadmin.yml');
        }
    }

    /**
     * @param ContainerBuilder $container
     * process() is called after all extensions are loaded
     */
    public function process(ContainerBuilder $container)
    {

    }
}
