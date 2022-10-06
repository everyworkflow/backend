<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataFormBundle\Field;

use EveryWorkflow\DataFormBundle\Field\Trait\ClearableTrait;

class TimeRangePickerField extends BaseField implements TimeRangePickerFieldInterface
{
    use ClearableTrait;

    protected string $fieldType = 'time_range_picker_field';
}
