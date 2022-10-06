<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataFormBundle\Factory;

use EveryWorkflow\DataFormBundle\Field\BaseFieldInterface;

interface FormFieldFactoryInterface
{
    public function createFromClassName(string $className, array $data = []): ?BaseFieldInterface;

    public function createFromType(string $fieldType, array $data = []): ?BaseFieldInterface;

    public function create(array $data = []): ?BaseFieldInterface;
}
