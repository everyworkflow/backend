<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use EveryWorkflow\DataGridBundle\Model\Collection\RepositorySource;
use EveryWorkflow\DataGridBundle\Model\DataGridConfig;
use EveryWorkflow\PageBundle\DataGrid\PageDataGrid;
use EveryWorkflow\PageBundle\Repository\PageRepository;
use Symfony\Component\DependencyInjection\Loader\Configurator\DefaultsConfigurator;

return function (ContainerConfigurator $configurator) {
    /** @var DefaultsConfigurator $services */
    $services = $configurator
        ->services()
        ->defaults()
        ->autowire()
        ->autoconfigure();

    $services
        ->load('EveryWorkflow\\PageBundle\\', '../../*')
        ->exclude('../../{DependencyInjection,Resources,Support,Tests}');

    $services->set('ew_cms_page_grid_config', DataGridConfig::class);
    $services->set('ew_cms_page_grid_source', RepositorySource::class)
        ->arg('$baseRepository', service(PageRepository::class))
        ->arg('$dataGridConfig', service('ew_cms_page_grid_config'));
    $services->set(PageDataGrid::class)
        ->arg('$source', service('ew_cms_page_grid_source'))
        ->arg('$dataGridConfig', service('ew_cms_page_grid_config'));
};
