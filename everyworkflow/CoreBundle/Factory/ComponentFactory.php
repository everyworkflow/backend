<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CoreBundle\Factory;

use EveryWorkflow\CoreBundle\Component\BaseComponentInterface;
use EveryWorkflow\CoreBundle\Model\DataObjectFactoryInterface;

class ComponentFactory implements ComponentFactoryInterface
{
    public function __construct(
        protected DataObjectFactoryInterface $dataObjectFactory
    ) {
    }

    public function create(string $className, array $data = []): BaseComponentInterface
    {
        $dataObject = $this->dataObjectFactory->create($data);

        return new $className($dataObject);
    }
}
