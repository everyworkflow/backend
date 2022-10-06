<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataFormBundle\Field\Select;

use EveryWorkflow\CoreBundle\Model\DataObjectInterface;

class Option implements OptionInterface
{
    protected DataObjectInterface $dataObject;

    public function __construct(DataObjectInterface $dataObject)
    {
        $this->dataObject = $dataObject;
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

    public function setIsEnabled(bool $isEnabled): self
    {
        $this->dataObject->setData(self::KEY_IS_ENABLED, $isEnabled);
        return $this;
    }

    public function getIsEnabled(): ?bool
    {
        return $this->dataObject->getData(self::KEY_IS_ENABLED);
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

    public function setChildren(array $children): self
    {
        $this->dataObject->setData(self::KEY_CHILDREN, $children);

        return $this;
    }

    public function getChildren(): array
    {
        return $this->dataObject->getData(self::KEY_CHILDREN) ?? [];
    }

    public function toArray(): array
    {
        $data = $this->dataObject->toArray();
        if (isset($data[self::KEY_CHILDREN])) {
            foreach ($data[self::KEY_CHILDREN] as $key => $item) {
                if ($item instanceof Option) {
                    $data[self::KEY_CHILDREN][$key] = $item->toArray();
                }
            }
        }

        return $data;
    }
}
