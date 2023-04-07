<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CoreBundle\Model;

use EveryWorkflow\CoreBundle\Support\ArrayableInterface;

interface DataObjectInterface extends ArrayableInterface
{
    public function setData(string $key, mixed $val): DataObjectInterface;

    public function setDataIfNot(string $key, mixed $val): DataObjectInterface;

    public function getData(string $key): mixed;

    /**
     * @param array<int,mixed> $data
     */
    public function resetData(array $data): DataObjectInterface;
}
