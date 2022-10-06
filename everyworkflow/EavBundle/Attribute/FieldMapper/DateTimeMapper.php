<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Attribute\FieldMapper;

use EveryWorkflow\EavBundle\Attribute\BaseFieldMapper;

class DateTimeMapper extends BaseFieldMapper implements DateTimeMapperInterface
{
    protected string $fieldType = 'date_time_picker_field';
}
