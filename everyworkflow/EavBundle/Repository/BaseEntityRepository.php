<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Repository;

use EveryWorkflow\CoreBundle\Factory\ValidatorFactoryInterface;
use EveryWorkflow\CoreBundle\Helper\CoreHelperInterface;
use EveryWorkflow\CoreBundle\Model\SystemDateTimeInterface;
use EveryWorkflow\CoreBundle\Support\ArrayableInterface;
use EveryWorkflow\DataFormBundle\Model\FormInterface;
use EveryWorkflow\EavBundle\Attribute\BaseAttributeInterface;
use EveryWorkflow\EavBundle\Entity\BaseEntityInterface;
use EveryWorkflow\EavBundle\Form\EntityAttributeFormInterface;
use EveryWorkflow\EavBundle\Support\Attribute\EntityRepositoryAttribute;
use EveryWorkflow\MongoBundle\Factory\DocumentFactoryInterface;
use EveryWorkflow\MongoBundle\Model\MongoConnectionInterface;
use EveryWorkflow\MongoBundle\Repository\BaseDocumentRepository;
use MongoDB\Model\BSONDocument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class BaseEntityRepository extends BaseDocumentRepository implements BaseEntityRepositoryInterface
{
    /**
     * @var string - Entity unique identifier, must be defined
     * @var array  - Entity attributes
     */
    public function __construct(
        protected AttributeGroupRepositoryInterface $attributeGroupRepository,
        protected AttributeRepositoryInterface $attributeRepository,
        protected EntityAttributeFormInterface $entityAttributeForm,
        DocumentFactoryInterface $documentFactory,
        CoreHelperInterface $coreHelper,
        SystemDateTimeInterface $systemDateTime,
        ValidatorFactoryInterface $validatorFactory,
        EventDispatcherInterface $eventDispatcher,
        MongoConnectionInterface $mongoConnection,
        string $collectionName = '',
        string|array $primaryKey = '',
        array $indexKeys = [],
        string $eventPrefix = '',
        ?string $documentClass = null,
        protected string $entityCode = '',
        protected array $entityAttributes = []
    ) {
        parent::__construct(
            $documentFactory,
            $coreHelper,
            $systemDateTime,
            $validatorFactory,
            $eventDispatcher,
            $mongoConnection,
            $collectionName,
            $primaryKey,
            $indexKeys,
            $eventPrefix,
            $documentClass
        );
    }

    public function getRepositoryAttribute(): ?EntityRepositoryAttribute
    {
        if (!$this->repositoryAttribute) {
            $reflectionClass = new \ReflectionClass(get_class($this));
            $attributes = $reflectionClass->getAttributes(EntityRepositoryAttribute::class);
            foreach ($attributes as $attribute) {
                $obj = $attribute->newInstance();
                if ($obj instanceof EntityRepositoryAttribute) {
                    $this->repositoryAttribute = $obj;
                }
            }
        }

        return $this->repositoryAttribute;
    }

    public function getEntityCode(): string
    {
        $respositoryAttribute = $this->getRepositoryAttribute();
        if (empty($this->entityCode) && $respositoryAttribute instanceof EntityRepositoryAttribute) {
            $this->entityCode = $respositoryAttribute->getEntityCode();
        }

        return $this->entityCode;
    }

    public function setEntityCode(string $entityCode): self
    {
        $this->entityCode = $entityCode;

        return $this;
    }

    public function create(array|BSONDocument $data = []): BaseEntityInterface
    {
        if ($data instanceof BSONDocument) {
            $data = $this->mapDocumentToArray($data);
        }

        return $this->documentFactory->create($this->getDocumentClass(), $data);
    }

    /**
     * @throws PrimaryKeyMissingException
     * @throws \Exception
     */
    public function saveOne(
        ArrayableInterface $document,
        array $otherFilter = [],
        array $otherOptions = []
    ): BaseEntityInterface {
        return parent::saveOne($document, $otherFilter, $otherOptions);
    }

    /**
     * @return BaseAttributeInterface[]
     */
    public function getAttributes(): array
    {
        if (!$this->entityAttributes) {
            $attributes = $this->attributeRepository->find(['entity_code' => $this->getEntityCode()]);
            foreach ($attributes as $attribute) {
                $this->entityAttributes[$attribute->getData('code')] = $attribute;
            }
        }

        return $this->entityAttributes;
    }

    public function getForm(): FormInterface
    {
        return $this->entityAttributeForm->loadAttributeFields($this);
    }
}
