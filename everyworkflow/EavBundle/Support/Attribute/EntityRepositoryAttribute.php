<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

namespace EveryWorkflow\EavBundle\Support\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class EntityRepositoryAttribute extends \EveryWorkflow\MongoBundle\Support\Attribute\RepositoryAttribute
{
    protected string $entityCode = '';

    public function __construct(
        string $documentClass,
        string|array $primaryKey = '_id',
        ?string $collectionName = null,
        string|array|null $indexKey = null,
        $eventPrefix = null,
        string $entityCode = ''
    ) {
        parent::__construct($documentClass, $primaryKey, $collectionName, $indexKey, $eventPrefix);
        $this->entityCode = $entityCode;
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
