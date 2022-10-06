<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataFormBundle\Field;

class MultiSelectField extends SelectField implements MultiSelectFieldInterface
{
    protected string $fieldType = 'multi_select_field';
}
