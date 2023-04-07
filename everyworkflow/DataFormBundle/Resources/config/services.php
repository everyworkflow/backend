<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use EveryWorkflow\DataFormBundle\Field\BaseField;
use EveryWorkflow\DataFormBundle\Field\BaseFieldInterface;
use EveryWorkflow\DataFormBundle\Field\TextField;
use EveryWorkflow\DataFormBundle\Field\TextFieldInterface;
use EveryWorkflow\DataFormBundle\Model\Form;
use EveryWorkflow\DataFormBundle\Model\FormInterface;

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
        ->load('EveryWorkflow\\DataFormBundle\\', '../../*')
        ->exclude('../../{DependencyInjection,Resources,Support,Tests}');

    $services->set(BaseField::class);
    $services->alias(BaseFieldInterface::class, BaseField::class);
    $services->set(TextField::class);
    $services->alias(TextFieldInterface::class, TextField::class);

    $services->set(FormInterface::class, Form::class);
};
