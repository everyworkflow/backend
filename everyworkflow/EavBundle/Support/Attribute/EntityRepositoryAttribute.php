<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

namespace EveryWorkflow\EavBundle\Support\Attribute;

#[\Attribute(\Attribute::TARGET_CLASS)]
class EntityRepositoryAttribute extends \EveryWorkflow\MongoBundle\Support\Attribute\RepositoryAttribute
{
    public function __construct(
        string $documentClass,
        string|array $primaryKey = '_id',
        ?string $collectionName = null,
        string|array|null $indexKey = null,
        $eventPrefix = null,
        protected string $entityCode = ''
    ) {
        parent::__construct($documentClass, $primaryKey, $collectionName, $indexKey, $eventPrefix);
    }

    public function setEntityCode(string $entityCode): self
    {
        $this->entityCode = $entityCode;

        return $this;
    }

    public function getEntityCode(): string
    {
        return $this->entityCode;
    }
}
