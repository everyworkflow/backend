<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataFormBundle\Field;

class FileField extends BaseField implements FileFieldInterface
{
    protected string $fieldType = 'file_field';
}
