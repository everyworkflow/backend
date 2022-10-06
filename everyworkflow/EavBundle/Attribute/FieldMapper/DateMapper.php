<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Attribute\FieldMapper;

use EveryWorkflow\EavBundle\Attribute\BaseFieldMapper;

class DateMapper extends BaseFieldMapper implements DateMapperInterface
{
    protected string $fieldType = 'date_picker_field';
}
