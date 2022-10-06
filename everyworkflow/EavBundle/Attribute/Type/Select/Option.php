<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Attribute\Type\Select;

use EveryWorkflow\CoreBundle\Model\DataObject;

class Option implements OptionInterface
{
    protected DataObject $dataObject;

    public function __construct(DataObject $dataObject)
    {
        $this->dataObject = $dataObject;
        $this->dataObject->setDataIfNot(self::KEY_SORT_ORDER, 0);
    }

    public function setKey(string $key): self
    {
        $this->dataObject->setData(self::KEY_KEY, $key);

        return $this;
    }

    public function getKey(): ?string
    {
        return $this->dataObject->getData(self::KEY_KEY);
    }

    public function setValue(string $val): self
    {
        $this->dataObject->setData(self::KEY_VALUE, $val);
        return $this;
    }

    public function getValue(): ?string
    {
        return $this->dataObject->getData(self::KEY_VALUE);
    }

    public function setSortOrder(int $sortOrder): self
    {
        $this->dataObject->setData(self::KEY_SORT_ORDER, $sortOrder);
        return $this;
    }

    public function getSortOrder(): ?int
    {
        return $this->dataObject->getData(self::KEY_SORT_ORDER);
    }

    public function toArray(): array
    {
        return $this->dataObject->toArray();
    }
}
