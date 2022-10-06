<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataFormBundle\Field;

class RowField extends BaseField implements RowFieldInterface
{
    protected string $fieldType = 'row_field';
}
