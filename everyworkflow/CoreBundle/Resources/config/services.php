<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use EveryWorkflow\CoreBundle\EventListener\KernelExceptionListener;
use EveryWorkflow\CoreBundle\Model\DataObject;
use EveryWorkflow\CoreBundle\Model\DataObjectFactory;
use EveryWorkflow\CoreBundle\Model\DataObjectFactoryInterface;
use EveryWorkflow\CoreBundle\Model\DataObjectInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

return function (ContainerConfigurator $configurator) {
    $services = $configurator
        ->services()
        ->defaults()
        ->autowire()
        ->autoconfigure();

    if (isset($_SERVER['APP_ENV']) && 'test' === $_SERVER['APP_ENV']) {
        $services->public();
    }

    $services
        ->load('EveryWorkflow\\CoreBundle\\', '../../*')
        ->exclude('../../{DependencyInjection,Resources,Support,Tests}');

    $services->set(DataObjectInterface::class, DataObject::class)->share(false);
    $services->set(DataObjectFactoryInterface::class, DataObjectFactory::class);

    $services->set(KernelExceptionListener::class)
        ->tag('kernel.event_listener', ['event' => 'kernel.exception']);

    $services->alias(ContainerInterface::class, 'service_container');
};
