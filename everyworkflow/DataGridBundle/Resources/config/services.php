<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use EveryWorkflow\DataGridBundle\Model\Collection\ArraySource;
use EveryWorkflow\DataGridBundle\Model\Collection\ArraySourceInterface;
use EveryWorkflow\DataGridBundle\Model\Collection\RepositorySource;
use EveryWorkflow\DataGridBundle\Model\Collection\RepositorySourceInterface;

return function (ContainerConfigurator $configurator) {
    /** @var DefaultsConfigurator $services */
    $services = $configurator
        ->services()
        ->defaults()
        ->autowire()
        ->autoconfigure();

    if (isset($_SERVER['APP_ENV']) && 'test' === $_SERVER['APP_ENV']) {
        $services->public();
    }

    $services
        ->load('EveryWorkflow\\DataGridBundle\\', '../../*')
        ->exclude('../../{DependencyInjection,Resources,Support,Tests}');

    $services->set(ArraySourceInterface::class, ArraySource::class);
    $services->set(RepositorySourceInterface::class, RepositorySource::class);
};
