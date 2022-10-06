<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Attribute;

use EveryWorkflow\DataFormBundle\Field\BaseFieldInterface;

interface BaseFieldMapperInterface
{
    public function map(BaseAttributeInterface $attribute): BaseFieldInterface;
}
