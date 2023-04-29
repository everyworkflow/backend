<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

namespace EveryWorkflow\MongoBundle\Support\Attribute;

use Attribute;
use Doctrine\Inflector\InflectorFactory;

#[Attribute(Attribute::TARGET_CLASS)]
class RepositoryAttribute
{
    public function __construct(
        protected string $documentClass,
        protected string|array $primaryKey = '_id',
        protected ?string $collectionName = null,
        protected string|array|null $indexKey = null,
        protected ?string $eventPrefix = null
    ) {
    }

    public function setDocumentClass(string $documentClass): self
    {
        $this->documentClass = $documentClass;

        return $this;
    }

    public function getDocumentClass(): string
    {
        return $this->documentClass;
    }

    public function setPrimaryKey(string|array $primaryKey): self
    {
        $this->primaryKey = $primaryKey;

        return $this;
    }

    public function getPrimaryKey(): string|array
    {
        return $this->primaryKey;
    }

    public function setCollectionName(string $collectionName): self
    {
        $this->collectionName = $collectionName;

        return $this;
    }

    public function getCollectionName(): string
    {
        /* Build collection name using document class if doesn't exist */
        if (!$this->collectionName) {
            $docClass = $this->getDocumentClass();
            $docClassArr = explode('\\', $docClass);
            $docClassName = end($docClassArr);
            $collectionName = InflectorFactory::create()->build()->tableize($docClassName);
            $collectionClassArr = explode('_', $collectionName);
            if ($collectionClassArr[count($collectionClassArr) - 1] === 'document') {
                array_pop($collectionClassArr);
            }
            $collectionClassArr[] = 'collection';
            $collectionName = implode('_', $collectionClassArr);
            $this->collectionName = $collectionName;
        }

        return $this->collectionName;
    }

    public function setIndexKey(string|array $indexKey): self
    {
        $this->indexKey = $indexKey;

        return $this;
    }

    public function getIndexKey(): string|array|null
    {
        return $this->indexKey;
    }

    public function setEventPrefix(string $eventPrefix): self
    {
        $this->eventPrefix = $eventPrefix;

        return $this;
    }

    public function getEventPrefix(): string
    {
        if ($this->eventPrefix) {
            return $this->eventPrefix;
        }

        $collectionName = $this->getCollectionName();
        $collectionName = str_replace('_collection', '', $collectionName);
        return $collectionName . '_';
    }
}
