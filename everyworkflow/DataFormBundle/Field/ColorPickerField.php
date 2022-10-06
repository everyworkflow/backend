<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataFormBundle\Field;

use EveryWorkflow\DataFormBundle\Field\Trait\ClearableTrait;

class ColorPickerField extends BaseField implements ColorPickerFieldInterface
{
    use ClearableTrait;

    protected string $fieldType = 'color_picker_field';
}
