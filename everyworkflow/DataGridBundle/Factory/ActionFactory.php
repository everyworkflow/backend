<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataGridBundle\Factory;

use EveryWorkflow\CoreBundle\Model\DataObjectFactoryInterface;
use EveryWorkflow\DataGridBundle\Model\ActionInterface;

class ActionFactory implements ActionFactoryInterface
{
    public function __construct(
        protected DataObjectFactoryInterface $dataObjectFactory
    ) {
    }

    public function create(string $className, array $data = []): ActionInterface
    {
        return new $className($this->dataObjectFactory->create($data));
    }
}
