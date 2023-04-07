<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CoreBundle\Model;

class DataObject implements DataObjectInterface
{
    /**
     * @param array<int,mixed> $data
     */
    public function __construct(
        protected array $data = []
    ) {
    }

    public function setData(string $key, mixed $val): self
    {
        $this->data[$key] = $val;

        return $this;
    }

    public function setDataIfNot(string $key, mixed $val): self
    {
        if (!isset($this->data[$key])) {
            $this->data[$key] = $val;
        }

        return $this;
    }

    public function getData(string $key): mixed
    {
        return $this->data[$key] ?? null;
    }

    /**
     * @param array<int,mixed> $data
     */
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
