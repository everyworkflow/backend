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

    $services
        ->load('EveryWorkflow\\SwaggerBundle\\', '../../*')
        ->exclude('../../{DependencyInjection,Resources,Support,Tests}');

    $services->set(\EveryWorkflow\SwaggerBundle\Model\Swagger\PathGenerator::class)
        ->arg('$router', service('router'));
};
