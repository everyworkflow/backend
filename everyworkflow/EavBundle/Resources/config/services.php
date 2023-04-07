<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use EveryWorkflow\DataGridBundle\Model\Collection\RepositorySource;
use EveryWorkflow\DataGridBundle\Model\DataGrid;
use EveryWorkflow\EavBundle\Attribute\BaseAttribute;
use EveryWorkflow\EavBundle\Attribute\BaseAttributeInterface;
use EveryWorkflow\EavBundle\Controller\Attribute\ListAttributeController;
use EveryWorkflow\EavBundle\Controller\Entity\ListEntityController;
use EveryWorkflow\EavBundle\Factory\AttributeFactory;
use EveryWorkflow\EavBundle\Form\AttributeForm;
use EveryWorkflow\EavBundle\Form\AttributeFormInterface;
use EveryWorkflow\EavBundle\Form\EntityForm;
use EveryWorkflow\EavBundle\GridConfig\AttributeGridConfig;
use EveryWorkflow\EavBundle\GridConfig\EntityGridConfig;
use EveryWorkflow\EavBundle\Repository\AttributeRepository;
use EveryWorkflow\EavBundle\Repository\EntityRepository;

return function (ContainerConfigurator $configurator) {
    $services = $configurator->services()
        ->defaults()
        ->autowire()
        ->autoconfigure();

    if (isset($_SERVER['APP_ENV']) && 'test' === $_SERVER['APP_ENV']) {
        $services->public();
    }

    $services->load('EveryWorkflow\\EavBundle\\', '../../*')
        ->exclude('../../{DependencyInjection,Resources,Tests}');

    $services->set(\EveryWorkflow\EavBundle\Support\Attribute\EntityRepositoryAttribute::class)
        ->autowire(false)
        ->autoconfigure(false);

    $services->alias(BaseAttributeInterface::class, BaseAttribute::class);

    $services->set(AttributeRepository::class)
        ->arg('$documentFactory', service(AttributeFactory::class));

    $services->set(AttributeFormInterface::class, AttributeForm::class);

    $services->set('ew_entity_grid_config', EntityGridConfig::class);
    $services->set('ew_entity_grid_source', RepositorySource::class)
        ->arg('$baseRepository', service(EntityRepository::class))
        ->arg('$dataGridConfig', service('ew_entity_grid_config'))
        ->arg('$form', service(EntityForm::class));
    $services->set('ew_entity_grid', DataGrid::class)
        ->arg('$source', service('ew_entity_grid_source'))
        ->arg('$dataGridConfig', service('ew_entity_grid_config'))
        ->arg('$form', service(EntityForm::class));
    $services->set(ListEntityController::class)
        ->arg('$dataGrid', service('ew_entity_grid'));

    $services->set('ew_attribute_grid_config', AttributeGridConfig::class);
    $services->set('ew_attribute_grid_source', RepositorySource::class)
        ->arg('$baseRepository', service(AttributeRepository::class))
        ->arg('$dataGridConfig', service('ew_attribute_grid_config'))
        ->arg('$form', service(AttributeForm::class));
    $services->set('ew_attribute_grid', DataGrid::class)
        ->arg('$source', service('ew_attribute_grid_source'))
        ->arg('$dataGridConfig', service('ew_attribute_grid_config'))
        ->arg('$form', service(AttributeForm::class));
    $services->set(ListAttributeController::class)
        ->arg('$dataGrid', service('ew_attribute_grid'));
};
