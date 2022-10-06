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
use Symfony\Component\DependencyInjection\Loader\Configurator\DefaultsConfigurator;

return function (ContainerConfigurator $configurator) {
    /** @var DefaultsConfigurator $services */
    $services = $configurator
        ->services()
        ->defaults()
        ->autowire()
        ->autoconfigure();

    $services
        ->load('EveryWorkflow\\DataFormBundle\\', '../../*')
        ->exclude('../../{DependencyInjection,Resources,Support,Tests}');

    $services->set(BaseField::class);
    $services->alias(BaseFieldInterface::class, BaseField::class);
    $services->set(TextField::class);
    $services->alias(TextFieldInterface::class, TextField::class);

    $services->set(FormInterface::class, Form::class);
};
