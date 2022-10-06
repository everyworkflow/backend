<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataFormBundle\Factory;

use EveryWorkflow\DataFormBundle\Model\FormInterface;

interface FormFactoryInterface
{
    public function create(array $data = []): ?FormInterface;
    
    public function createByClassName($className): ?FormInterface;
}
