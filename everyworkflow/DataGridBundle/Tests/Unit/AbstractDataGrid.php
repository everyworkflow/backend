<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

namespace EveryWorkflow\DataGridBundle\Tests\Unit;

use EveryWorkflow\DataFormBundle\Factory\FieldOptionFactory;
use EveryWorkflow\DataFormBundle\Factory\FormFactory;
use EveryWorkflow\DataFormBundle\Factory\FormFieldFactory;
use EveryWorkflow\DataFormBundle\Field\Select\Option;
use EveryWorkflow\DataFormBundle\Model\FormInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\Container;

class AbstractDataGrid extends KernelTestCase
{
    /**
     * @return array<int,array<string,mixed>>
     */
    protected function getExampleUserData(): array
    {
        $userData = [];
        for ($i = 0; $i < 50; ++$i) {
            try {
                $userData[] = [
                'first_name' => 'Test ' . $i,
                'last_name' => 'Name ' . $i,
                'email' => 'test' . $i . '@example.com',
                'gender' => random_int(0, 1) ? 'male' : 'female',
                ];
            } catch (\Exception $e) {
            }
        }

        return $userData;
    }

    protected function getExampleUserForm(Container $container): FormInterface
    {
        $formFieldFactory = $container->get(FormFieldFactory::class);
        $formFactory = $container->get(FormFactory::class);
        $fieldOptionFactory = $container->get(FieldOptionFactory::class);

        $form = $formFactory->create();

        $form->setFields([
        $formFieldFactory->create([
            'label' => 'First name',
            'name' => 'first_name',
        ]),
        $formFieldFactory->create([
            'label' => 'Last name',
            'name' => 'last_name',
        ]),
        $formFieldFactory->create([
            'label' => 'Email',
            'name' => 'email',
            'input_type' => 'email',
        ]),
        $formFieldFactory->create([
            'label' => 'Gender',
            'name' => 'gender',
            'field_type' => 'select_field',
            'options' => [
                $fieldOptionFactory->create(Option::class, [
                    'key' => 'male',
                    'value' => 'Male',
                ]),
                $fieldOptionFactory->create(Option::class, [
                    'key' => 'female',
                    'value' => 'Female',
                ]),
                $fieldOptionFactory->create(Option::class, [
                    'key' => 'other',
                    'value' => 'Other',
                ]),
            ],
        ]),
        ]);

        return $form;
    }
}
