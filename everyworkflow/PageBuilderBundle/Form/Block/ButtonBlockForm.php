<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\PageBuilderBundle\Form\Block;

use EveryWorkflow\DataFormBundle\Field\Select\Option;

class ButtonBlockForm extends AbstractBlockForm implements ButtonBlockFormInterface
{
    public function getFields(): array
    {
        $fields = [
            $this->formFieldFactory->create([
                'label' => 'Button label',
                'name' => 'button_label',
                'field_type' => 'text_field',
            ]),
            $this->formFieldFactory->create([
                'label' => 'Button path',
                'name' => 'button_path',
                'field_type' => 'text_field',
            ]),
            $this->formFieldFactory->create([
                'label' => 'Button target',
                'name' => 'button_target',
                'field_type' => 'select_field',
                'options' => [
                    $this->fieldOptionFactory->create(Option::class, [
                        'key' => '',
                        'value' => 'Default',
                    ]),
                    $this->fieldOptionFactory->create(Option::class, [
                        'key' => '_blank',
                        'value' => 'Blank - Opens in a new window or tab',
                    ]),
                    $this->fieldOptionFactory->create(Option::class, [
                        'key' => '_self',
                        'value' => 'Self - Opens in the same frame as it was clicked (default)',
                    ]),
                    $this->fieldOptionFactory->create(Option::class, [
                        'key' => '_parent',
                        'value' => 'Blank - Opens in the parent frame',
                    ]),
                    $this->fieldOptionFactory->create(Option::class, [
                        'key' => '_top',
                        'value' => 'Blank - Opens in the named iframe',
                    ]),
                ],
            ]),
            $this->formFieldFactory->create([
                'label' => 'Button type',
                'name' => 'button_type',
                'field_type' => 'select_field',
                'options' => [
                    $this->fieldOptionFactory->create(Option::class, [
                        'key' => 'default',
                        'value' => 'Default',
                    ]),
                    $this->fieldOptionFactory->create(Option::class, [
                        'key' => 'primary',
                        'value' => 'Primary',
                    ]),
                    $this->fieldOptionFactory->create(Option::class, [
                        'key' => 'dashed',
                        'value' => 'Dashed',
                    ]),
                    $this->fieldOptionFactory->create(Option::class, [
                        'key' => 'text',
                        'value' => 'Text',
                    ]),
                    $this->fieldOptionFactory->create(Option::class, [
                        'key' => 'link',
                        'value' => 'Link',
                    ]),
                    $this->fieldOptionFactory->create(Option::class, [
                        'key' => 'ghost',
                        'value' => 'Ghost',
                    ]),
                ],
            ]),
            $this->formFieldFactory->create([
                'label' => 'Button size',
                'name' => 'button_size',
                'field_type' => 'select_field',
                'options' => [
                    $this->fieldOptionFactory->create(Option::class, [
                        'key' => '',
                        'value' => 'Default',
                    ]),
                    $this->fieldOptionFactory->create(Option::class, [
                        'key' => 'middle',
                        'value' => 'Middle',
                    ]),
                    $this->fieldOptionFactory->create(Option::class, [
                        'key' => 'large',
                        'value' => 'Large',
                    ]),
                    $this->fieldOptionFactory->create(Option::class, [
                        'key' => 'small',
                        'value' => 'Small',
                    ]),
                ],
            ]),
            $this->formFieldFactory->create([
                'label' => 'Button shape',
                'name' => 'button_shape',
                'field_type' => 'select_field',
                'options' => [
                    $this->fieldOptionFactory->create(Option::class, [
                        'key' => '',
                        'value' => 'Default',
                    ]),
                    $this->fieldOptionFactory->create(Option::class, [
                        'key' => 'circle',
                        'value' => 'Circle',
                    ]),
                    $this->fieldOptionFactory->create(Option::class, [
                        'key' => 'round',
                        'value' => 'Round',
                    ]),
                ],
            ]),
            $this->formFieldFactory->create([
                'label' => 'Button ghost (transparent)',
                'name' => 'button_ghost',
                'field_type' => 'switch_field',
            ]),
            $this->formFieldFactory->create([
                'label' => 'Button danger',
                'name' => 'button_danger',
                'field_type' => 'switch_field',
            ]),
            $this->formFieldFactory->create([
                'label' => 'Button block',
                'name' => 'button_block',
                'field_type' => 'switch_field',
            ]),
        ];

        return array_merge($fields, parent::getFields());
    }
}
