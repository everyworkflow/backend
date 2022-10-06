<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\PageBuilderBundle\Form\Block;

use EveryWorkflow\DataFormBundle\Field\Select\Option;

class HeadingBlockForm extends AbstractBlockForm implements HeadingBlockFormInterface
{
    public function getFields(): array
    {
        $fields = [
            $this->formFieldFactory->create([
                'label' => 'Heading type',
                'name' => 'heading_type',
                'field_type' => 'select_field',
                'options' => [
                    $this->fieldOptionFactory->create(Option::class, [
                        'key' => 'h1',
                        'value' => 'H1',
                    ]),
                    $this->fieldOptionFactory->create(Option::class, [
                        'key' => 'h2',
                        'value' => 'H2',
                    ]),
                    $this->fieldOptionFactory->create(Option::class, [
                        'key' => 'h3',
                        'value' => 'H3',
                    ]),
                    $this->fieldOptionFactory->create(Option::class, [
                        'key' => 'h4',
                        'value' => 'H4',
                    ]),
                    $this->fieldOptionFactory->create(Option::class, [
                        'key' => 'h5',
                        'value' => 'H5',
                    ]),
                ],
            ]),
            $this->formFieldFactory->create([
                'label' => 'Content',
                'name' => 'content',
                'field_type' => 'text_field',
            ]),
        ];

        return array_merge($fields, parent::getFields());
    }
}
