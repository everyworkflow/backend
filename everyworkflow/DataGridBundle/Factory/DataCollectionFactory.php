<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataGridBundle\Factory;

use EveryWorkflow\CoreBundle\Model\DataObjectFactoryInterface;
use EveryWorkflow\DataGridBundle\Model\DataCollection;
use EveryWorkflow\DataGridBundle\Model\DataCollectionInterface;

class DataCollectionFactory implements DataCollectionFactoryInterface
{
    public function __construct(
        protected DataObjectFactoryInterface $dataObjectFactory
    ) {
    }

    public function create(array $data = []): DataCollectionInterface
    {
        return new DataCollection($this->dataObjectFactory->create($data));
    }
}
