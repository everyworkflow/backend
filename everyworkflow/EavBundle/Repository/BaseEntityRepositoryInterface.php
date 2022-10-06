<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Repository;

use EveryWorkflow\CoreBundle\Support\ArrayableInterface;
use EveryWorkflow\DataFormBundle\Model\FormInterface;
use EveryWorkflow\EavBundle\Attribute\BaseAttributeInterface;
use EveryWorkflow\EavBundle\Entity\BaseEntityInterface;
use EveryWorkflow\MongoBundle\Repository\BaseDocumentRepositoryInterface;

interface BaseEntityRepositoryInterface extends BaseDocumentRepositoryInterface
{
    public function getEntityCode(): string;

    public function setEntityCode(string $entityCode): self;

    public function create(array $data = []): BaseEntityInterface;

    /**
     * @throws PrimaryKeyMissingException
     * @throws \Exception
     */
    public function saveOne(
        ArrayableInterface $document,
        array $otherFilter = [],
        array $otherOptions = []
    ): BaseEntityInterface;

    /**
     * @return BaseAttributeInterface[]
     *
     * @throws \ReflectionException
     */
    public function getAttributes(): array;

    public function getForm(): FormInterface;
}
