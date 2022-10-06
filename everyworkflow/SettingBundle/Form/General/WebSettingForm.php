<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\SettingBundle\Form\General;

use EveryWorkflow\DataFormBundle\Model\Form;

class WebSettingForm extends Form implements WebSettingFormInterface
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
                'label' => 'Base URL',
                'name' => 'base_url',
                'field_type' => 'text_field',
                'is_required' => true
            ]),
            $this->formFieldFactory->create([
                'label' => 'Media Base URL',
                'name' => 'media_base_url',
                'field_type' => 'text_field',
                'is_required' => true
            ]),
        ];

        $sortOrder = 5;
        foreach ($fields as $field) {
            $field->setSortOrder($sortOrder++);
        }

        return $fields;
    }
}
