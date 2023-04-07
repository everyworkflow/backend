<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Attribute\FieldMapper;

use EveryWorkflow\EavBundle\Attribute\BaseFieldMapper;

class BooleanMapper extends BaseFieldMapper implements BooleanMapperInterface
{
    protected string $fieldType = 'switch_field';
}
