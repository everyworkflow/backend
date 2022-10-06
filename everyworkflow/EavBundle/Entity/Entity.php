<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Entity;

use EveryWorkflow\CoreBundle\Model\DataObjectInterface;
use EveryWorkflow\EavBundle\Attribute\BaseAttributeInterface;

class Entity implements EntityInterface
{
    /**
     * @var DataObjectInterface
     */
    protected DataObjectInterface $dataObject;
    /**
     * @var BaseAttributeInterface[]
     */
    protected array $attributes;

    public function __construct(
        DataObjectInterface $dataObject,
        array $attributes = []
    ) {
        $this->dataObject = $dataObject;
        $this->attributes = $attributes;
    }

    public function getId(): ?string
    {
        return $this->dataObject->getData(self::KEY_ID);
    }

    public function setCode(string $code): self
    {
        $this->dataObject->setData(self::KEY_CODE, $code);

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->dataObject->getData(self::KEY_CODE);
    }

    public function setClass(string $class): self
    {
        $this->dataObject->setData(self::KEY_CLASS, $class);

        return $this;
    }

    public function getClass(): ?string
    {
        return $this->dataObject->getData(self::KEY_CLASS);
    }

    public function setName(string $name): self
    {
        $this->dataObject->setData(self::KEY_NAME, $name);

        return $this;
    }

    public function getName(): ?string
    {
        return $this->dataObject->getData(self::KEY_NAME);
    }

    /**
     * @param BaseAttributeInterface[]
     * @return Entity
     */
    public function setAttributes(array $attributes): self
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * @return BaseAttributeInterface[]
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function toArray(): array
    {
        return $this->dataObject->toArray();
    }
}
