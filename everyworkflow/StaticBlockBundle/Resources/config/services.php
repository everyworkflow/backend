<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use EveryWorkflow\DataGridBundle\Model\Collection\RepositorySource;
use EveryWorkflow\DataGridBundle\Model\DataGrid;
use EveryWorkflow\StaticBlockBundle\Controller\ListStaticBlockController;
use EveryWorkflow\StaticBlockBundle\Form\StaticBlockForm;
use EveryWorkflow\StaticBlockBundle\GridConfig\StaticBlockGridConfig;
use EveryWorkflow\StaticBlockBundle\Repository\StaticBlockRepository;
use Symfony\Component\DependencyInjection\Loader\Configurator\DefaultsConfigurator;

return function (ContainerConfigurator $configurator) {
    /** @var DefaultsConfigurator $services */
    $services = $configurator
        ->services()
        ->defaults()
        ->autowire()
        ->autoconfigure();

    $services
        ->load('EveryWorkflow\\StaticBlockBundle\\', '../../*')
        ->exclude('../../{DependencyInjection,Resources,Support,Tests}');

    $services->set('ew_cms_static_block_config', StaticBlockGridConfig::class);
    $services->set('ew_cms_static_block_grid_source', RepositorySource::class)
        ->arg('$baseRepository', service(StaticBlockRepository::class))
        ->arg('$dataGridConfig', service('ew_cms_static_block_config'));
    $services->set('ew_cms_static_block_grid', DataGrid::class)
        ->arg('$source', service('ew_cms_static_block_grid_source'))
        ->arg('$dataGridConfig', service('ew_cms_static_block_config'))
        ->arg('$form', service(StaticBlockForm::class));
    $services->set(ListStaticBlockController::class)
        ->arg('$dataGrid', service('ew_cms_static_block_grid'));
};
