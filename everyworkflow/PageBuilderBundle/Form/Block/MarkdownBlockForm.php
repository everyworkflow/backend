<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\PageBuilderBundle\Form\Block;

class MarkdownBlockForm extends AbstractBlockForm implements MarkdownBlockFormInterface
{
    public function getFields(): array
    {
        $fields = [
            $this->formFieldFactory->create([
                'label' => 'Content',
                'name' => 'content',
                'field_type' => 'markdown_field',
            ]),
        ];

        return array_merge($fields, parent::getFields());
    }
}
