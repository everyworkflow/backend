<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Attribute\Type;

class NumberAttribute extends TextAttribute implements NumberAttributeInterface
{
    protected string $attributeType = 'number_attribute';
}
