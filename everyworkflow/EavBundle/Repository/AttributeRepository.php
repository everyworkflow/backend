<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Repository;

use EveryWorkflow\EavBundle\Attribute\BaseAttribute;
use EveryWorkflow\EavBundle\Attribute\BaseAttributeInterface;
use EveryWorkflow\EavBundle\Factory\AttributeFactoryInterface;
use EveryWorkflow\MongoBundle\Repository\BaseDocumentRepository;
use EveryWorkflow\MongoBundle\Support\Attribute\RepositoryAttribute;
use MongoDB\Model\BSONDocument;
use Symfony\Contracts\Service\Attribute\Required;

#[RepositoryAttribute(
    documentClass: BaseAttribute::class,
    collectionName: 'attribute_collection',
    primaryKey: ['entity_code', 'code']
)]
class AttributeRepository extends BaseDocumentRepository implements AttributeRepositoryInterface
{
    protected ?AttributeFactoryInterface $attributeFactory = null;

    #[Required]
    public function setAttributeFactory(AttributeFactoryInterface $attributeFactory): self
    {
        $this->attributeFactory = $attributeFactory;

        return $this;
    }

    public function getAttributeFactory(): ?AttributeFactoryInterface
    {
        return $this->attributeFactory;
    }

    public function create(array|BSONDocument $data = []): BaseAttributeInterface
    {
        if ($data instanceof BSONDocument) {
            $data = $this->mapDocumentToArray($data);
        }
        if ($this->getAttributeFactory()) {
            return $this->getAttributeFactory()->createAttribute($data);
        }

        return parent::create($data);
    }
}
