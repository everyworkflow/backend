<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataFormBundle\Field;

use EveryWorkflow\DataFormBundle\Field\Trait\ClearableTrait;

class DateTimePickerField extends BaseField implements DateTimePickerFieldInterface
{
    use ClearableTrait;

    protected string $fieldType = 'date_time_picker_field';
}
