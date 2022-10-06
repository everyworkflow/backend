<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\FrontPanelBundle\Form;

use EveryWorkflow\DataFormBundle\Model\Form;

class FrontendSettingForm extends Form implements FrontendSettingFormInterface
{
    /**
     * @return BaseSectionInterface[]
     */
    public function getSections(): array
    {
        $sections = [
            $this->getFormSectionFactory()->create([
                'section_type' => 'card_section',
                'title' => 'General',
            ])->setFields($this->getGeneralFields()),
        ];
        return array_merge($sections, parent::getSections());
    }

    protected function getGeneralFields(): array
    {
        $fields = [
            $this->formFieldFactory->create([
                'label' => 'Frontend Title',
                'name' => 'frontend_title',
                'field_type' => 'text_field',
                'is_required' => true,
            ]),
            $this->formFieldFactory->create([
                'label' => 'Layout',
                'name' => 'layout',
                'field_type' => 'select_field',
                'options' => [
                    [
                        'key' => 'default',
                        'value' => 'Default',
                    ],
                ],
                'is_required' => true,
            ]),
            $this->formFieldFactory->create([
                'label' => 'Theme',
                'name' => 'theme',
                'field_type' => 'select_field',
                'options' => [
                    [
                        'key' => 'default',
                        'value' => 'Default',
                    ],
                ],
                'is_required' => true,
            ]),
            $this->formFieldFactory->create([
                'label' => 'Copyright Text',
                'name' => 'copyright_text',
                'field_type' => 'text_field',
            ]),
        ];

        $sortOrder = 5;
        foreach ($fields as $field) {
            $field->setSortOrder($sortOrder++);
        }

        return $fields;
    }
}
