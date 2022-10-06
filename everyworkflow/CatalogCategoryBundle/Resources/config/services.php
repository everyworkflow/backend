<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use EveryWorkflow\CatalogCategoryBundle\DataGrid\CatalogCategoryDataGrid;
use EveryWorkflow\CatalogCategoryBundle\Repository\CatalogCategoryRepository;
use EveryWorkflow\DataGridBundle\Model\Collection\RepositorySource;
use EveryWorkflow\DataGridBundle\Model\DataGridConfig;
use Symfony\Component\DependencyInjection\Loader\Configurator\DefaultsConfigurator;

return function (ContainerConfigurator $configurator) {
    /** @var DefaultsConfigurator $services */
    $services = $configurator
        ->services()
        ->defaults()
        ->autowire()
        ->autoconfigure();

    $services
        ->load('EveryWorkflow\\CatalogCategoryBundle\\', '../../*')
        ->exclude('../../{DependencyInjection,Resources,Support,Tests}');

    $services->set('ew_catalog_category_grid_config', DataGridConfig::class);
    $services->set('ew_catalog_category_grid_source', RepositorySource::class)
        ->arg('$baseRepository', service(CatalogCategoryRepository::class))
        ->arg('$dataGridConfig', service('ew_catalog_category_grid_config'));
    $services->set(CatalogCategoryDataGrid::class)
        ->arg('$source', service('ew_catalog_category_grid_source'))
        ->arg('$dataGridConfig', service('ew_catalog_category_grid_config'));
};
