<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataFormBundle\Factory;

use EveryWorkflow\CoreBundle\Model\DataObjectFactoryInterface;

class FieldOptionFactory implements FieldOptionFactoryInterface
{
    public function __construct(
        protected DataObjectFactoryInterface $dataObjectFactory
    ) {
    }

    public function create(string $className, array $data): mixed
    {
        $dataObject = $this->dataObjectFactory->create($data);
        if (class_exists($className)) {
            return new $className($dataObject);
        }

        return null;
    }
}
