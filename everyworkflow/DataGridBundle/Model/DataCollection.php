<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataGridBundle\Model;

use EveryWorkflow\CoreBundle\Model\DataObjectInterface;
use EveryWorkflow\CoreBundle\Support\ArrayableInterface;

class DataCollection implements DataCollectionInterface
{
    protected array $results = [];

    protected DataObjectInterface $dataObject;

    public function __construct(DataObjectInterface $dataObject)
    {
        $this->dataObject = $dataObject;
    }

    /**
     * @return ArrayableInterface[]
     */
    public function getResults(): array
    {
        return $this->results;
    }

    /**
     * @param ArrayableInterface[] $results
     *
     * @return $this
     */
    public function setResults(array $results): self
    {
        $this->results = $results;

        return $this;
    }

    public function getFrom(): int
    {
        return $this->dataObject->getData(self::KEY_FROM) ?? 0;
    }

    public function setFrom(int $from): self
    {
        $this->dataObject->setData(self::KEY_FROM, $from);

        return $this;
    }

    public function getTo(): int
    {
        return $this->dataObject->getData(self::KEY_TO) ?? 0;
    }

    public function setTo(int $to): self
    {
        $this->dataObject->setData(self::KEY_TO, $to);

        return $this;
    }

    public function getPerPage(): int
    {
        return $this->dataObject->getData(self::KEY_PER_PAGE) ?? 20;
    }

    public function setPerPage(int $perPage): self
    {
        $this->dataObject->setData(self::KEY_PER_PAGE, $perPage);

        return $this;
    }

    public function getCurrentPage(): int
    {
        return $this->dataObject->getData(self::KEY_CURRENT_PAGE) ?? 1;
    }

    public function setCurrentPage(int $currentPage): self
    {
        $this->dataObject->setData(self::KEY_CURRENT_PAGE, $currentPage);

        return $this;
    }

    public function getLastPage(): int
    {
        return $this->dataObject->getData(self::KEY_LAST_PAGE) ?? 1;
    }

    public function setLastPage(int $lastPage): self
    {
        $this->dataObject->setData(self::KEY_LAST_PAGE, $lastPage);

        return $this;
    }

    public function getTotalCount(): int
    {
        return $this->dataObject->getData(self::KEY_TOTAL_COUNT) ?? 0;
    }

    public function setTotalCount(int $totalCount): self
    {
        $this->dataObject->setData(self::KEY_TOTAL_COUNT, $totalCount);

        return $this;
    }

    public function getResultCount(): int
    {
        return $this->dataObject->getData(self::KEY_RESULT_COUNT) ?? 0;
    }

    public function setResultCount(int $resultCount): self
    {
        $this->dataObject->setData(self::KEY_RESULT_COUNT, $resultCount);

        return $this;
    }

    public function toArray(): array
    {
        $data = [
            self::KEY_META => $this->dataObject->toArray(),
            self::KEY_RESULTS => [],
        ];

        foreach ($this->getResults() as $item) {
            if ($item instanceof ArrayableInterface) {
                $data[self::KEY_RESULTS][] = $item->toArray();
            }
        }

        return $data;
    }
}
