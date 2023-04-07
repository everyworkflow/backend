<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\MediaManagerBundle\Attribute\Type;

use EveryWorkflow\EavBundle\Attribute\BaseAttribute;

class MediaAttribute extends BaseAttribute implements MediaAttributeInterface
{
    protected string $attributeType = 'long_text_attribute';
}
