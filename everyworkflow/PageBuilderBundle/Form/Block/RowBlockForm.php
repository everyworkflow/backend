<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\PageBuilderBundle\Form\Block;

use EveryWorkflow\DataFormBundle\Field\Select\Option;

class RowBlockForm extends AbstractBlockForm implements RowBlockFormInterface
{
    public function getFields(): array
    {
        $fields = [
            $this->formFieldFactory->create([
                'label' => 'Gutter',
                'name' => 'gutter',
                'field_type' => 'text_field',
                'input_type' => 'number',
            ]),
            $this->formFieldFactory->create([
                'label' => 'Align',
                'name' => 'align',
                'field_type' => 'select_field',
                'options' => [
                    $this->fieldOptionFactory->create(Option::class, [
                        'key' => 'top',
                        'value' => 'Top',
                    ]),
                    $this->fieldOptionFactory->create(Option::class, [
                        'key' => 'middle',
                        'value' => 'Middle',
                    ]),
                    $this->fieldOptionFactory->create(Option::class, [
                        'key' => 'bottom',
                        'value' => 'Bottom',
                    ]),
                    $this->fieldOptionFactory->create(Option::class, [
                        'key' => 'stretch',
                        'value' => 'Stretch',
                    ]),
                ],
            ]),
            $this->formFieldFactory->create([
                'label' => 'Justify',
                'name' => 'justify',
                'field_type' => 'select_field',
                'options' => [
                    $this->fieldOptionFactory->create(Option::class, [
                        'key' => 'start',
                        'value' => 'Start',
                    ]),
                    $this->fieldOptionFactory->create(Option::class, [
                        'key' => 'end',
                        'value' => 'End',
                    ]),
                    $this->fieldOptionFactory->create(Option::class, [
                        'key' => 'center',
                        'value' => 'Center',
                    ]),
                    $this->fieldOptionFactory->create(Option::class, [
                        'key' => 'space-around',
                        'value' => 'Space around',
                    ]),
                    $this->fieldOptionFactory->create(Option::class, [
                        'key' => 'space-between',
                        'value' => 'Space between',
                    ]),
                ],
            ]),
            $this->formFieldFactory->create([
                'label' => 'Wrap',
                'name' => 'wrap',
                'field_type' => 'switch_field',
            ]),
        ];

        return array_merge($fields, parent::getFields());
    }
}
