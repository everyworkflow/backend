<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Document;

use EveryWorkflow\CoreBundle\Validation\Type\BooleanValidation;
use EveryWorkflow\CoreBundle\Validation\Type\NumberValidation;
use EveryWorkflow\CoreBundle\Validation\Type\StringValidation;
use EveryWorkflow\MongoBundle\Document\BaseDocument;
use EveryWorkflow\MongoBundle\Document\HelperTrait\CreatedUpdatedHelperTrait;
use EveryWorkflow\MongoBundle\Document\HelperTrait\StatusHelperTrait;

class AttributeDocument extends BaseDocument implements AttributeDocumentInterface
{
    use CreatedUpdatedHelperTrait;
    use StatusHelperTrait;

    #[StringValidation(required: true, minLength: 3, maxLength: 50)]
    public function setCode(string $code): self
    {
        $this->dataObject->setData(self::KEY_CODE, $code);

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->dataObject->getData(self::KEY_CODE);
    }

    #[StringValidation(required: true)]
    public function setName(string $name): self
    {
        $this->dataObject->setData(self::KEY_NAME, $name);

        return $this;
    }

    public function getName(): ?string
    {
        return $this->dataObject->getData(self::KEY_NAME);
    }

    #[StringValidation(required: true)]
    public function setType(string $type): self
    {
        $this->dataObject->setData(self::KEY_TYPE, $type);

        return $this;
    }

    public function getType(): ?string
    {
        return $this->dataObject->getData(self::KEY_TYPE);
    }

    #[StringValidation()]
    public function setClass(string $className): self
    {
        $this->dataObject->setData(self::KEY_CLASS, $className);

        return $this;
    }

    public function getClass(): ?string
    {
        return $this->dataObject->getData(self::KEY_CLASS);
    }

    #[StringValidation(required: true)]
    public function setEntityCode(string $entityCode): self
    {
        $this->dataObject->setData(self::KEY_ENTITY_CODE, $entityCode);

        return $this;
    }

    public function getEntityCode(): ?string
    {
        return $this->dataObject->getData(self::KEY_ENTITY_CODE);
    }

    #[BooleanValidation(default: false)]
    public function setIsRequired(bool $isRequired): self
    {
        $this->dataObject->setData(self::KEY_IS_REQUIRED, $isRequired);

        return $this;
    }

    public function isRequired(): bool
    {
        return $this->dataObject->getData(self::KEY_IS_REQUIRED);
    }

    #[BooleanValidation(default: false)]
    public function setIsReadonly(bool $isReadonly): self
    {
        $this->dataObject->setData(self::KEY_IS_READONLY, $isReadonly);

        return $this;
    }

    public function isReadonly(): bool
    {
        return $this->dataObject->getData(self::KEY_IS_READONLY);
    }

    #[BooleanValidation(default: false)]
    public function setIsUsedInGrid(bool $isUsedInGrid): self
    {
        $this->dataObject->setData(self::KEY_IS_USED_IN_GRID, $isUsedInGrid);
        return $this;
    }

    public function isUsedInGrid(): bool
    {
        return (bool)$this->dataObject->getData(self::KEY_IS_USED_IN_GRID);
    }

    #[BooleanValidation(default: false)]
    public function setIsUsedInForm(bool $isUsedInForm): self
    {
        $this->dataObject->setData(self::KEY_IS_USED_IN_FORM, $isUsedInForm);
        return $this;
    }

    public function isUsedInForm(): bool
    {
        return (bool)$this->dataObject->getData(self::KEY_IS_USED_IN_FORM);
    }

    #[NumberValidation()]
    public function setSortOrder(int $sortOrder): self
    {
        $this->dataObject->setData(self::KEY_SORT_ORDER, $sortOrder);

        return $this;
    }

    public function getSortOrder(): ?int
    {
        return $this->dataObject->getData(self::KEY_SORT_ORDER);
    }
}
