<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Form;

use EveryWorkflow\DataFormBundle\Model\Form;

class EntityForm extends Form implements EntityFormInterface
{
    /**
     * @return BaseSectionInterface[]
     */
    public function getSections(): array
    {
        $sections = [
            $this->getFormSectionFactory()->create([
                'section_type' => 'card_section',
                'code' => 'general',
                'title' => 'General',
            ])->setFields($this->getGeneralFields()),
        ];
        return array_merge($sections, parent::getSections());
    }

    protected function getGeneralFields(): array
    {
        $fields = [
            $this->formFieldFactory->create([
                'label' => 'UUID',
                'name' => '_id',
                'is_readonly' => true,
            ]),
            $this->formFieldFactory->create([
                'label' => 'Code',
                'name' => 'code',
            ]),
            $this->formFieldFactory->create([
                'label' => 'Name',
                'name' => 'name',
            ]),
            $this->formFieldFactory->create([
                'label' => 'Class',
                'name' => 'class',
            ]),
            $this->formFieldFactory->create([
                'label' => 'Status',
                'name' => 'status',
                'field_type' => 'select_field',
                'options' => [
                    [
                        'key' => 'enable',
                        'value' => 'Enable',
                    ],
                    [
                        'key' => 'disable',
                        'value' => 'Disable',
                    ],
                ],
            ]),
            $this->formFieldFactory->create([
                'label' => 'Sort order',
                'name' => 'sort_order',
                'field_type' => 'text_field',
                'input_type' => 'number'
            ]),
            $this->formFieldFactory->create([
                'label' => 'Created at',
                'name' => 'created_at',
                'is_readonly' => true,
                'field_type' => 'date_time_picker_field',
            ]),
            $this->formFieldFactory->create([
                'label' => 'Updated at',
                'name' => 'updated_at',
                'is_readonly' => true,
                'field_type' => 'date_time_picker_field',
            ]),
        ];

        $sortOrder = 5;
        foreach ($fields as $field) {
            $field->setSortOrder($sortOrder++);
        }

        return $fields;
    }
}
