<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataFormBundle\Field;

use EveryWorkflow\DataFormBundle\Field\Trait\ClearableTrait;

class TimePickerField extends BaseField implements TimePickerFieldInterface
{
    use ClearableTrait;

    protected string $fieldType = 'time_picker_field';
}
