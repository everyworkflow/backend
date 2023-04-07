<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

namespace EveryWorkflow\DataFormBundle\Tests\Unit;

use EveryWorkflow\DataFormBundle\Factory\FieldOptionFactory;
use EveryWorkflow\DataFormBundle\Factory\FormFieldFactory;
use EveryWorkflow\DataFormBundle\Field\Select\Option;
use EveryWorkflow\DataFormBundle\Field\SelectField;
use EveryWorkflow\DataFormBundle\Field\TextField;
use EveryWorkflow\DataFormBundle\Model\DataFormConfigProvider;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class FormFieldTest extends KernelTestCase
{
    public function testDefaultTextFormField(): void
    {
        self::bootKernel();
        $container = self::getContainer();

        /** @var DataFormConfigProvider $dataFormConfigProvider */
        $dataFormConfigProvider = $container->get(DataFormConfigProvider::class);
        /** @var FormFieldFactory $formFieldFactory */
        $formFieldFactory = $container->get(FormFieldFactory::class);

        /** @var TextField $firstNameField */
        $firstNameField = $formFieldFactory->create([
            'label' => 'First name',
            'name' => 'first_name',
        ]);

        $this->assertEquals(
            $dataFormConfigProvider->get('default.field'),
            $firstNameField->getFieldType(),
            'Default field type must be equal to ' . $dataFormConfigProvider->get('default.field')
        );

        /** @var TextField $lastNameField */
        $lastNameField = $formFieldFactory->create([
            'label' => 'Last name',
            'name' => 'last_name',
            'field_type' => 'text_field',
        ]);

        $lastNameFieldData = $lastNameField->toArray();

        $this->assertArrayHasKey('label', $lastNameFieldData);
        $this->assertArrayHasKey('name', $lastNameFieldData);
        $this->assertArrayHasKey('field_type', $lastNameFieldData);
    }

    public function testSelectField(): void
    {
        self::bootKernel();
        $container = self::getContainer();

        /** @var FormFieldFactory $formFieldFactory */
        $formFieldFactory = $container->get(FormFieldFactory::class);
        /** @var FieldOptionFactory $fieldOptionFactory */
        $fieldOptionFactory = $container->get(FieldOptionFactory::class);

        /** @var SelectField $selectField */
        $selectField = $formFieldFactory->create([
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
        ]);

        $genderFieldData = $selectField->toArray();

        $this->assertArrayHasKey('label', $genderFieldData);
        $this->assertArrayHasKey('name', $genderFieldData);
        $this->assertArrayHasKey('field_type', $genderFieldData);
        $this->assertArrayHasKey('options', $genderFieldData);

        $this->assertArrayHasKey('key', $genderFieldData['options'][0]);
        $this->assertArrayHasKey('value', $genderFieldData['options'][0]);

        $this->assertEquals('female', $genderFieldData['options'][1]['key']);
        $this->assertEquals('Female', $genderFieldData['options'][1]['value']);
    }
}
