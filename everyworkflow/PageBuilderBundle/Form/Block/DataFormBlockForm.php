<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\PageBuilderBundle\Form\Block;

class DataFormBlockForm extends AbstractBlockForm implements DataFormBlockFormInterface
{
    public function getFields(): array
    {
        $fields = [
            // Something
        ];

        return array_merge($fields, parent::getFields());
    }
}
