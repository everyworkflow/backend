<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataFormBundle\Model;

use EveryWorkflow\CoreBundle\Model\DataObjectInterface;
use EveryWorkflow\DataFormBundle\Factory\FormFieldFactoryInterface;
use EveryWorkflow\DataFormBundle\Factory\FormSectionFactoryInterface;
use EveryWorkflow\DataFormBundle\Field\BaseFieldInterface;
use EveryWorkflow\DataFormBundle\Section\BaseSectionInterface;

class Form implements FormInterface
{
    protected array $fields = [];
    protected array $sections = [];

    protected DataObjectInterface $dataObject;
    protected FormSectionFactoryInterface $formSectionFactory;
    protected FormFieldFactoryInterface $formFieldFactory;

    public function __construct(
        DataObjectInterface $dataObject,
        FormSectionFactoryInterface $formSectionFactory,
        FormFieldFactoryInterface $formFieldFactory
    ) {
        $this->dataObject = $dataObject;
        $this->formSectionFactory = $formSectionFactory;
        $this->formFieldFactory = $formFieldFactory;
    }

    public function setFormUpdatePath(string $formUpdatePath): self
    {
        $this->dataObject->setData(self::KEY_FORM_UPDATE_PATH, $formUpdatePath);
        return $this;
    }

    public function getFormUpdatePath(): ?string
    {
        return $this->dataObject->getData(self::KEY_FORM_UPDATE_PATH);
    }

    public function setIsSideFormAnchorEnable(bool $isSideFormAnchorEnable): self
    {
        $this->dataObject->setData(self::KEY_IS_SIDE_FORM_ANCHOR_ENABLE, $isSideFormAnchorEnable);
        return $this;
    }

    public function isSideFormAnchorEnable(): ?bool
    {
        return $this->dataObject->getData(self::KEY_IS_SIDE_FORM_ANCHOR_ENABLE);
    }

    public function setSideFormAnchorPosition(string $sideFormAnchorPosition): self
    {
        $this->dataObject->setData(self::KEY_SIDE_FORM_ANCHOR_POSITION, $sideFormAnchorPosition);
        return $this;
    }

    public function getSideFormAnchorPosition(): ?string
    {
        return $this->dataObject->getData(self::KEY_SIDE_FORM_ANCHOR_POSITION);
    }

    public function getFormFieldFactory(): FormFieldFactoryInterface
    {
        return $this->formFieldFactory;
    }

    public function getFormSectionFactory(): FormSectionFactoryInterface
    {
        return $this->formSectionFactory;
    }

    /**
     * @return BaseSectionInterface[]
     */
    public function getSections(): array
    {
        return $this->sections;
    }

    /**
     * @param BaseSectionInterface[] $sections
     */
    public function setSections(array $sections): self
    {
        $this->sections = $sections;

        return $this;
    }

    /**
     * @return BaseFieldInterface[]
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * @param BaseFieldInterface[] $fields
     */
    public function setFields(array $fields): self
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * @param BaseFieldInterface[] $fields
     */
    public function addFields(array $fields): self
    {
        foreach ($fields as $name => $field) {
            if ($field instanceof BaseFieldInterface) {
                $keyName = $name;
                if (!is_string($keyName)) {
                    $keyName = $field->getName();
                }
                $this->fields[$keyName] = $field;
            }
        }

        return $this;
    }

    public function addIfNot(string $name, BaseFieldInterface $baseField): self
    {
        if (!isset($this->fields[$name])) {
            $this->fields[$name] = $baseField;
        }

        return $this;
    }

    public function addField(string $name, BaseFieldInterface $baseField): self
    {
        $this->fields[$name] = $baseField;

        return $this;
    }

    public function removeField(string $name): self
    {
        if (isset($this->fields[$name])) {
            unset($this->fields[$name]);
        }

        return $this;
    }

    public function resetData(array $data): self
    {
        $this->dataObject->resetData($data);
        return $this;
    }

    public function toArray(): array
    {
        $data = $this->dataObject->toArray();

        $fields = [];
        foreach ($this->getFields() as $field) {
            if ($field instanceof BaseFieldInterface) {
                $fields[] = $field->toArray();
            } else if (is_array($field)) {
                $fields[] = $field;
            }
        }
        uasort($fields, function ($a, $b) {
            $aSortOrder = $a['sort_order'] ?? null;
            $bSortOrder = $b['sort_order'] ?? null;
            if ($aSortOrder === null && $bSortOrder !== null) return 1;
            if ($aSortOrder > $bSortOrder) return 1;
            if ($aSortOrder < $bSortOrder) return -1;
        });
        $data[self::KEY_FIELDS] = array_values($fields);

        $sections = [];
        foreach ($this->getSections() as $section) {
            if ($section instanceof BaseSectionInterface) {
                $sections[] = $section->toArray();
            } else if (is_array($section)) {
                $sections[] = $section;
            }
        }

        uasort($sections, function ($a, $b) {
            $aSortOrder = $a['sort_order'] ?? null;
            $bSortOrder = $b['sort_order'] ?? null;
            if ($aSortOrder === null && $bSortOrder !== null) return 1;
            if ($aSortOrder > $bSortOrder) return 1;
            if ($aSortOrder < $bSortOrder) return -1;
        });
        $data[self::KEY_SECTIONS] = array_values($sections);

        return $data;
    }
}
