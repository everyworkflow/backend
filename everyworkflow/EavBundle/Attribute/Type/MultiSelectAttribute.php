<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Attribute\Type;

class MultiSelectAttribute extends SelectAttribute implements MultiSelectAttributeInterface
{
    protected string $attributeType = 'multi_select_attribute';
}
