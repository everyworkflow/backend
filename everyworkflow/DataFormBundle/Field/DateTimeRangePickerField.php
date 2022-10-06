<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataFormBundle\Field;

use EveryWorkflow\DataFormBundle\Field\Trait\ClearableTrait;

class DateTimeRangePickerField extends BaseField implements DateTimeRangePickerFieldInterface
{
    use ClearableTrait;

    protected string $fieldType = 'date_time_range_picker_field';
}
