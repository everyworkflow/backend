<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Attribute\FieldMapper;

class MultiSelectMapper extends SelectMapper implements MultiSelectMapperInterface
{
    protected string $fieldType = 'multi_select_field';
}
