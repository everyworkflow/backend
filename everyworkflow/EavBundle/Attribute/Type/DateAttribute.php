<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Attribute\Type;

use EveryWorkflow\EavBundle\Attribute\BaseAttribute;

class DateAttribute extends BaseAttribute implements DateAttributeInterface
{
    protected string $attributeType = 'date_attribute';
}
