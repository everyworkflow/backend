<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CoreBundle\Model;

use EveryWorkflow\CoreBundle\Support\ArrayableInterface;

interface DataObjectInterface extends ArrayableInterface
{
    /**
     * @param string $key
     * @param mixed $val
     * @return self
     */
    public function setData(string $key, mixed $val): self;

    /**
     * @param string $key
     * @param mixed $val
     * @return self
     */
    public function setDataIfNot(string $key, mixed $val): self;

    /**
     * @param string $key
     * @return mixed
     */
    public function getData(string $key) : mixed;

    public function resetData(array $data): self;
}
