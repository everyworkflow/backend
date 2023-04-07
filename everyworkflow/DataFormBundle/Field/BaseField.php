<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataFormBundle\Field;

use EveryWorkflow\CoreBundle\Model\DataObjectInterface;

class BaseField implements BaseFieldInterface
{
    protected string $fieldType = 'base_field';

    public function __construct(
        protected DataObjectInterface $dataObject
    ) {
    }

    public function getFieldType(): string
    {
        return $this->fieldType;
    }

    public function getId(): ?string
    {
        return $this->dataObject->getData(self::KEY_ID);
    }

    public function setId(string $id): self
    {
        $this->dataObject->setData(self::KEY_ID, $id);

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->dataObject->getData(self::KEY_LABEL);
    }

    public function setLabel(string $label): self
    {
        $this->dataObject->setData(self::KEY_LABEL, $label);

        return $this;
    }

    public function getName(): ?string
    {
        return $this->dataObject->getData(self::KEY_NAME);
    }

    public function setName(string $name): self
    {
        $this->dataObject->setData(self::KEY_NAME, $name);

        return $this;
    }

    public function getValue(): mixed
    {
        return $this->dataObject->getData(self::KEY_VALUE);
    }

    public function setValue(mixed $value): self
    {
        $this->dataObject->setData(self::KEY_VALUE, $value);

        return $this;
    }

    public function getSortOrder(): ?int
    {
        return $this->dataObject->getData(self::KEY_SORT_ORDER);
    }

    public function setSortOrder(int $sortOrder): self
    {
        $this->dataObject->setData(self::KEY_SORT_ORDER, $sortOrder);

        return $this;
    }

    public function getHelpText(): ?string
    {
        return $this->dataObject->getData(self::KEY_HELP_TEXT);
    }

    public function setHelpText(string $helpText): self
    {
        $this->dataObject->setData(self::KEY_HELP_TEXT, $helpText);

        return $this;
    }

    public function getDefaultValue(): mixed
    {
        return $this->dataObject->getData(self::KEY_DEFAULT_VALUE);
    }

    public function setDefaultValue(mixed $defaultValue): self
    {
        $this->dataObject->setData(self::KEY_DEFAULT_VALUE, $defaultValue);

        return $this;
    }

    public function isRequired(): ?bool
    {
        return $this->dataObject->getData(self::KEY_IS_REQUIRED);
    }

    public function setIsRequired(bool $isRequired): self
    {
        $this->dataObject->setData(self::KEY_IS_REQUIRED, $isRequired);

        return $this;
    }

    public function isDisabled(): ?bool
    {
        return $this->dataObject->getData(self::KEY_IS_DISABLED);
    }

    public function setIsDisabled(bool $isDisabled): self
    {
        $this->dataObject->setData(self::KEY_IS_DISABLED, $isDisabled);

        return $this;
    }

    public function isReadonly(): ?bool
    {
        return (bool) $this->dataObject->getData(self::KEY_IS_READONLY);
    }

    public function setIsReadonly(bool $isReadonly): self
    {
        $this->dataObject->setData(self::KEY_IS_READONLY, $isReadonly);

        return $this;
    }

    public function resetData($data): self
    {
        $this->dataObject->resetData($data);

        return $this;
    }

    /**
     * Export data to array.
     */
    public function toArray(): array
    {
        $data = $this->dataObject->toArray();
        $data['field_type'] = $this->getFieldType();

        /* Taking name as default _id of field */
        if (!isset($data['_id']) && isset($data['name'])) {
            $data['_id'] = $data['name'];
        }

        return $data;
    }
}
