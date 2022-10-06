<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

namespace EveryWorkflow\DataFormBundle\Tests;

use EveryWorkflow\DataFormBundle\Factory\FormFactory;
use EveryWorkflow\DataFormBundle\Factory\FormFactoryInterface;
use EveryWorkflow\DataFormBundle\Factory\FormFieldFactory;
use EveryWorkflow\DataFormBundle\Factory\FormFieldFactoryInterface;
use EveryWorkflow\DataFormBundle\Factory\FormSectionFactory;
use EveryWorkflow\DataFormBundle\Factory\FormSectionFactoryInterface;
use EveryWorkflow\DataFormBundle\Model\DataFormConfigProvider;
use EveryWorkflow\DataFormBundle\Model\DataFormConfigProviderInterface;
use EveryWorkflow\MongoBundle\Tests\BaseMongoTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

class BaseFormTestCase extends BaseMongoTestCase
{
    protected function getFormConfigProvider(array $configs = []): DataFormConfigProviderInterface
    {
        return new DataFormConfigProvider([
            'default' => [
                'section' => 'base_section',
                'field' => 'text_field'
            ],
            'sections' => [
                'base_section' => 'EveryWorkflow\DataFormBundle\Section\BaseSection',
                'card_section' => 'EveryWorkflow\DataFormBundle\Section\CardSection',
                'col_section' => 'EveryWorkflow\DataFormBundle\Section\ColSection',
                'row_section' => 'EveryWorkflow\DataFormBundle\Section\RowSection',
            ],
            'fields' => [
                'base_field' => 'EveryWorkflow\DataFormBundle\Field\BaseField',
                'text_field' => 'EveryWorkflow\DataFormBundle\Field\TextField',
                'textarea_field' => 'EveryWorkflow\DataFormBundle\Field\TextareaField',
                'select_field' => 'EveryWorkflow\DataFormBundle\Field\SelectField',
                'radio_field' => 'EveryWorkflow\DataFormBundle\Field\RadioField',
                'switch_field' => 'EveryWorkflow\DataFormBundle\Field\SwitchField',
            ],
            ...$configs,
        ]);
    }

    protected function getFormFieldFactory(ContainerInterface $container): FormFieldFactoryInterface
    {
        return new FormFieldFactory($container, $this->getFormConfigProvider());
    }

    protected function getFormSectionFactory(ContainerInterface $container): FormSectionFactoryInterface
    {
        return new FormSectionFactory($container, $this->getFormConfigProvider());
    }

    protected function getFormFactory(ContainerInterface $container): FormFactoryInterface
    {
        return new FormFactory($container);
    }
}
