<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

namespace EveryWorkflow\DataFormBundle\Tests\Unit;

use EveryWorkflow\DataFormBundle\Factory\FieldOptionFactory;
use EveryWorkflow\DataFormBundle\Field\Select\Option;
use EveryWorkflow\DataFormBundle\Field\SelectField;
use EveryWorkflow\DataFormBundle\Field\TextField;
use EveryWorkflow\DataFormBundle\Tests\BaseFormTestCase;

class FormFieldTest extends BaseFormTestCase
{
    public function test_default_text_form_field(): void
    {
        $container = self::getContainer();
        $dataFormConfigProvider = $this->getFormConfigProvider();
        $formFieldFactory = $this->getFormFieldFactory($container);

        /** @var TextField $firstNameField */
        $firstNameField = $formFieldFactory->create([
            'label' => 'First name',
            'name' => 'first_name',
        ]);

        self::assertEquals(
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

        self::assertArrayHasKey('label', $lastNameFieldData);
        self::assertArrayHasKey('name', $lastNameFieldData);
        self::assertArrayHasKey('field_type', $lastNameFieldData);
    }

    public function test_select_field(): void
    {
        $container = self::getContainer();
        $formFieldFactory = $this->getFormFieldFactory($container);
        $fieldOptionFactory = new FieldOptionFactory($this->getDataObjectFactory());

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

        self::assertArrayHasKey('label', $genderFieldData);
        self::assertArrayHasKey('name', $genderFieldData);
        self::assertArrayHasKey('field_type', $genderFieldData);
        self::assertArrayHasKey('options', $genderFieldData);

        self::assertArrayHasKey('key', $genderFieldData['options'][0]);
        self::assertArrayHasKey('value', $genderFieldData['options'][0]);

        self::assertEquals('female', $genderFieldData['options'][1]['key']);
        self::assertEquals('Female', $genderFieldData['options'][1]['value']);
    }
}
