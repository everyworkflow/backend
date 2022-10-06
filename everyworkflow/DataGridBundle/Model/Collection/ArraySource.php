<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataGridBundle\Model\Collection;

use EveryWorkflow\CoreBundle\Model\DataObjectFactoryInterface;
use EveryWorkflow\CoreBundle\Support\ArrayableInterface;
use EveryWorkflow\DataGridBundle\Model\DataCollectionInterface;
use Symfony\Component\HttpFoundation\Request;

class ArraySource implements ArraySourceInterface
{
    protected ?Request $request = null;
    /**
     * @var ArrayableInterface[]
     */
    protected array $results = [];

    public function __construct(
        protected DataCollectionInterface $dataCollection,
        protected DataObjectFactoryInterface $dataObjectFactory,
        array $results = [],
    ) {
        $this->results = $results;
    }

    public function setRequest(Request $request): self
    {
        $this->request = $request;

        return $this;
    }

    public function getRequest(): ?Request
    {
        return $this->request;
    }

    public function getCollection(): DataCollectionInterface
    {
        return $this->dataCollection;
    }

    public function setCollection(DataCollectionInterface $dataCollection): self
    {
        $this->dataCollection = $dataCollection;
        return $this;
    }

    protected function processResult(): array
    {
        return $this->results;
    }

    public function toCollection(): DataCollectionInterface
    {
        $collection = $this->getCollection();
        $results = [];
        foreach ($this->processResult() as $item) {
            if ($item instanceof ArrayableInterface) {
                $results[] = $item;
            } elseif (is_array($item)) {
                $results[] = $this->dataObjectFactory->create($item);
            }
        }
        $resultCount = count($results);
        $collection->setResults($results)
            ->setPerPage($resultCount)
            ->setResultCount($resultCount)
            ->setTotalCount($resultCount)
            ->setLastPage(1)
            ->setCurrentPage(1);
        return $collection;
    }

    public function toArray(): array
    {
        return $this->toCollection()->toArray();
    }
}
