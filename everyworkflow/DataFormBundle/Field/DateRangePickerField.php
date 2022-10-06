<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataFormBundle\Field;

use EveryWorkflow\DataFormBundle\Field\Trait\ClearableTrait;

class DateRangePickerField extends BaseField implements DateRangePickerFieldInterface
{
    use ClearableTrait;

    protected string $fieldType = 'date_range_picker_field';
}
