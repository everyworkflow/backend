<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Repository;

use EveryWorkflow\EavBundle\Attribute\BaseAttributeInterface;
use EveryWorkflow\EavBundle\Factory\AttributeFactoryInterface;
use EveryWorkflow\MongoBundle\Repository\BaseDocumentRepositoryInterface;

interface AttributeRepositoryInterface extends BaseDocumentRepositoryInterface
{
    public function setAttributeFactory(AttributeFactoryInterface $attributeFactory): self;

    public function getAttributeFactory(): ?AttributeFactoryInterface;

    public function create(array $data = []): BaseAttributeInterface;
}
