<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataFormBundle\Field;

class MarkdownField extends BaseField implements MarkdownFieldInterface
{
    protected string $fieldType = 'markdown_field';
}
