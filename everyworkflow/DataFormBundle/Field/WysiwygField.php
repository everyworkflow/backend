<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataFormBundle\Field;

class WysiwygField extends BaseField implements MarkdownFieldInterface
{
    protected string $fieldType = 'wysiwyg_field';
}
