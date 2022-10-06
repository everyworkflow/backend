<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Attribute\FieldMapper;

use EveryWorkflow\EavBundle\Attribute\BaseFieldMapper;

class TextMapper extends BaseFieldMapper implements TextMapperInterface
{
    protected string $fieldType = 'text_field';
}
