<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use EveryWorkflow\CatalogProductBundle\DataGrid\CatalogProductDataGrid;
use EveryWorkflow\CatalogProductBundle\Repository\CatalogProductRepository;
use EveryWorkflow\DataGridBundle\Model\Collection\RepositorySource;
use EveryWorkflow\DataGridBundle\Model\DataGridConfig;

return function (ContainerConfigurator $configurator) {
    /** @var DefaultsConfigurator $services */
    $services = $configurator
        ->services()
        ->defaults()
        ->autowire()
        ->autoconfigure();

    $services
        ->load('EveryWorkflow\\CatalogProductBundle\\', '../../*')
        ->exclude('../../{DependencyInjection,Resources,Support,Tests}');

    $services->set('ew_catalog_product_grid_config', DataGridConfig::class);
    $services->set('ew_catalog_product_grid_source', RepositorySource::class)
        ->arg('$baseRepository', service(CatalogProductRepository::class))
        ->arg('$dataGridConfig', service('ew_catalog_product_grid_config'));
    $services->set(CatalogProductDataGrid::class)
        ->arg('$source', service('ew_catalog_product_grid_source'))
        ->arg('$dataGridConfig', service('ew_catalog_product_grid_config'));
};
