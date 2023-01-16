<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataFormBundle\Tests\Unit;

use EveryWorkflow\DataFormBundle\Factory\FieldOptionFactory;
use EveryWorkflow\DataFormBundle\Factory\FormFactory;
use EveryWorkflow\DataFormBundle\Factory\FormFieldFactory;
use EveryWorkflow\DataFormBundle\Field\Select\Option;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class FormTest extends KernelTestCase
{
    public function test_basic_form(): void
    {
        self::bootKernel();
        $container = self::getContainer();

        $formFactory = $container->get(FormFactory::class);
        $formFieldFactory = $container->get(FormFieldFactory::class);
        $fieldOptionFactory = $container->get(FieldOptionFactory::class);

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

        $this->assertArrayHasKey('fields', $formData);

        $this->assertArrayHasKey('label', $formData['fields'][0]);
        $this->assertArrayHasKey('name', $formData['fields'][0]);
        $this->assertArrayHasKey('field_type', $formData['fields'][0]);

        $this->assertArrayHasKey('label', $formData['fields'][2]);
        $this->assertArrayHasKey('name', $formData['fields'][2]);
        $this->assertArrayHasKey('field_type', $formData['fields'][2]);
        $this->assertArrayHasKey('input_type', $formData['fields'][2]);
        $this->assertEquals('email', $formData['fields'][2]['input_type']);

        $this->assertArrayHasKey('label', $formData['fields'][3]);
        $this->assertArrayHasKey('name', $formData['fields'][3]);
        $this->assertArrayHasKey('field_type', $formData['fields'][3]);
        $this->assertArrayHasKey('options', $formData['fields'][3]);
        $this->assertArrayHasKey('key', $formData['fields'][3]['options'][0]);
        $this->assertArrayHasKey('value', $formData['fields'][3]['options'][0]);
        $this->assertEquals('male', $formData['fields'][3]['options'][0]['key']);
    }
}
