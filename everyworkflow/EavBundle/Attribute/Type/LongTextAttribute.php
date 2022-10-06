<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Attribute\Type;

class LongTextAttribute extends TextAttribute implements LongTextAttributeInterface
{
    protected string $attributeType = 'long_text_attribute';
}
