<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CoreBundle\Model;

interface DataObjectFactoryInterface
{
    /**
     * @param array<int,mixed> $data
     */
    public function create(array $data = []): DataObjectInterface;
    /**
     * @param array<int,mixed> $data
     */
    public function createFromClassName(string $className, array $data = []): DataObjectInterface;
    /**
     * @param array<int,mixed> $data
     */
    public function createObjectFromClassName(string $className, array $data = []): mixed;
}
