<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataGridBundle\Model;

use EveryWorkflow\CoreBundle\Model\DataObjectInterface;

class DataGridColumn implements DataGridColumnInterface
{
    /**
     * @var DataObjectInterface
     */
    protected DataObjectInterface $dataObject;

    public function __construct(DataObjectInterface $dataObject)
    {
        $this->dataObject = $dataObject;
    }

    public function getName(): ?string
    {
        return $this->dataObject->getData(self::KEY_NAME);
    }

    public function setName(string $name): self
    {
        $this->dataObject->setData(self::KEY_NAME, $name);
        return $this;
    }

    public function getSortOrder(): ?int
    {
        return $this->dataObject->getData(self::KEY_SORT_ORDER);
    }

    public function setSortOrder(int $sortOrder): self
    {
        $this->dataObject->setData(self::KEY_SORT_ORDER, $sortOrder);
        return $this;
    }

    public function getIsActive(): bool
    {
        return $this->dataObject->getData(self::KEY_IS_ACTIVE);
    }

    public function setIsActive(bool $isActive): self
    {
        $this->dataObject->setData(self::KEY_IS_ACTIVE, $isActive);
        return $this;
    }

    public function getIsSortable(): bool
    {
        return $this->dataObject->getData(self::KEY_IS_SORTABLE);
    }

    public function setIsSortable(bool $isSortable): self
    {
        $this->dataObject->setData(self::KEY_IS_SORTABLE, $isSortable);
        return $this;
    }

    public function getIsFilterable(): bool
    {
        return $this->dataObject->getData(self::KEY_IS_FILTERABLE);
    }

    public function setIsFilterable(bool $isFilterable): self
    {
        $this->dataObject->setData(self::KEY_IS_FILTERABLE, $isFilterable);
        return $this;
    }

    public function toArray(): array
    {
        return $this->dataObject->toArray();
    }
}
