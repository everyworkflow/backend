<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\PageBuilderBundle\Form\Block;

class ParagraphBlockForm extends AbstractBlockForm implements ParagraphBlockFormInterface
{
    public function getFields(): array
    {
        $fields = [
            $this->formFieldFactory->create([
                'label' => 'Content',
                'name' => 'content',
                'field_type' => 'textarea_field',
                'row_count' => 10,
            ]),
        ];

        return array_merge($fields, parent::getFields());
    }
}
