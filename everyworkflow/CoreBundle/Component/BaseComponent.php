<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CoreBundle\Component;

use EveryWorkflow\CoreBundle\Model\DataObjectInterface;

class BaseComponent implements BaseComponentInterface
{
    public function __construct(
        protected DataObjectInterface $dataObject
    ) {
    }

    public function toArray(): array
    {
        return $this->dataObject->toArray();
    }
}
