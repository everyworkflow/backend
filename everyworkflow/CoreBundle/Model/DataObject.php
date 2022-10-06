<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CoreBundle\Model;

class DataObject implements DataObjectInterface
{
    protected array $data = [];

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    /**
     * @param string $key
     * @param mixed $val
     * @return self
     */

    public function setData(string $key, mixed $val): self
    {
        $this->data[$key] = $val;
        return $this;
    }

    /**
     * @param string $key
     * @param mixed $val
     * @return self
     */
    public function setDataIfNot(string $key, mixed $val): self
    {
        if (!isset($this->data[$key])) {
            $this->data[$key] = $val;
        }
        return $this;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function getData(string $key): mixed
    {
        return $this->data[$key] ?? null;
    }

    public function resetData(array $data): self
    {
        $this->data = $data;
        return $this;
    }

    public function toArray(): array
    {
        return $this->data;
    }
}
