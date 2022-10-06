<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Attribute\FieldMapper;

use EveryWorkflow\EavBundle\Attribute\BaseFieldMapper;

class BooleanAttribute extends BaseFieldMapper implements BooleanAttributeInterface
{
    protected string $fieldType = 'switch_field';
}
