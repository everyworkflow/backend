<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

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
        ->load('EveryWorkflow\\CronBundle\\', '../../*')
        ->exclude('../../{DependencyInjection,Resources,Support,Tests}');

    $services->set(\EveryWorkflow\CronBundle\Model\CronJobList::class)
        ->arg('$cronJobs', tagged_iterator('everyworkflow.cron_jobs'));
};
