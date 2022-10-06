<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Attribute\Type;

use EveryWorkflow\EavBundle\Attribute\BaseAttribute;

class BooleanAttribute extends BaseAttribute implements BooleanAttributeInterface
{
    protected string $attributeType = 'boolean_attribute';
}
