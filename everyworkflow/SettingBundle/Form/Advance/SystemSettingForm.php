<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\SettingBundle\Form\Advance;

use EveryWorkflow\DataFormBundle\Model\Form;

class SystemSettingForm extends Form implements SystemSettingFormInterface
{
    /**
     * @return BaseSectionInterface[]
     */
    public function getSections(): array
    {
        $sections = [
            $this->getFormSectionFactory()->create([
                'section_type' => 'card_section',
                'title' => 'Backup',
            ])->setFields($this->getBackupFields()),
            $this->getFormSectionFactory()->create([
                'section_type' => 'card_section',
                'title' => 'Storage',
            ])->setFields($this->getStorageFields()),
        ];

        return array_merge($sections, parent::getSections());
    }

    protected function getBackupFields(): array
    {
        $fields = [
            $this->formFieldFactory->create([
                'label' => 'Backup',
                'name' => 'backup',
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
        ];

        $sortOrder = 5;
        foreach ($fields as $field) {
            $field->setSortOrder($sortOrder++);
        }

        return $fields;
    }

    protected function getStorageFields(): array
    {
        $fields = [
            $this->formFieldFactory->create([
                'label' => 'Media Storage',
                'name' => 'media_storage',
                'field_type' => 'select_field',
                'options' => [
                    [
                        'key' => 'file_system',
                        'value' => 'File System',
                    ],
                ],
                'is_required' => true,
            ]),
        ];

        $sortOrder = 5;
        foreach ($fields as $field) {
            $field->setSortOrder($sortOrder++);
        }

        return $fields;
    }
}
