<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Attribute\Type;

class CurrencyAttribute extends NumberAttribute implements CurrencyAttributeInterface
{
    protected string $attributeType = 'currency_attribute';
}
