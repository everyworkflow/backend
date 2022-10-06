<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Attribute\Type;

use EveryWorkflow\EavBundle\Attribute\BaseAttribute;

class DateTimeAttribute extends BaseAttribute implements DateTimeAttributeInterface
{
    protected string $attributeType = 'date_time_attribute';
}
