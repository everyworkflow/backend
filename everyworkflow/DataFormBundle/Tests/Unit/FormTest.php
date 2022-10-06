<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataFormBundle\Tests\Unit;

use EveryWorkflow\DataFormBundle\Factory\FieldOptionFactory;
use EveryWorkflow\DataFormBundle\Field\Select\Option;
use EveryWorkflow\DataFormBundle\Tests\BaseFormTestCase;

class FormTest extends BaseFormTestCase
{
    public function test_basic_form(): void
    {
        $container = self::getContainer();
        $formFieldFactory = $this->getFormFieldFactory($container);
        $formFactory = $this->getFormFactory($container);
        $fieldOptionFactory = new FieldOptionFactory($this->getDataObjectFactory());

        $form  = $formFactory->create();

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

        $formData = $form->toArray();

        self::assertArrayHasKey('fields', $formData);

        self::assertArrayHasKey('label', $formData['fields'][0]);
        self::assertArrayHasKey('name', $formData['fields'][0]);
        self::assertArrayHasKey('field_type', $formData['fields'][0]);

        self::assertArrayHasKey('label', $formData['fields'][2]);
        self::assertArrayHasKey('name', $formData['fields'][2]);
        self::assertArrayHasKey('field_type', $formData['fields'][2]);
        self::assertArrayHasKey('input_type', $formData['fields'][2]);
        self::assertEquals('email', $formData['fields'][2]['input_type']);

        self::assertArrayHasKey('label', $formData['fields'][3]);
        self::assertArrayHasKey('name', $formData['fields'][3]);
        self::assertArrayHasKey('field_type', $formData['fields'][3]);
        self::assertArrayHasKey('options', $formData['fields'][3]);
        self::assertArrayHasKey('key', $formData['fields'][3]['options'][0]);
        self::assertArrayHasKey('value', $formData['fields'][3]['options'][0]);
        self::assertEquals('male', $formData['fields'][3]['options'][0]['key']);
    }
}
