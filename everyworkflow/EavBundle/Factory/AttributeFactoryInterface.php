<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Factory;

use EveryWorkflow\EavBundle\Attribute\BaseAttributeInterface;
use EveryWorkflow\MongoBundle\Factory\DocumentFactoryInterface;

interface AttributeFactoryInterface extends DocumentFactoryInterface
{
    public function createAttributeFromType(string $type, array $data = []): ?BaseAttributeInterface;

    public function createAttribute(array $data = []): ?BaseAttributeInterface;
}
