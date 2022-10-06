<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataFormBundle\Model;

use EveryWorkflow\CoreBundle\Support\ArrayableInterface;
use EveryWorkflow\DataFormBundle\Factory\FormFieldFactoryInterface;
use EveryWorkflow\DataFormBundle\Factory\FormSectionFactoryInterface;
use EveryWorkflow\DataFormBundle\Field\BaseFieldInterface;

interface FormInterface extends ArrayableInterface
{
    public const SIDE_FORM_ANCHOR_POSITION_LEFT = 'left'; // default
    public const SIDE_FORM_ANCHOR_POSITION_RIGHT = 'right';

    public const KEY_FORM_UPDATE_PATH = 'form_update_path';
    public const KEY_IS_SIDE_FORM_ANCHOR_ENABLE = 'is_side_form_anchor_enable';
    public const KEY_SIDE_FORM_ANCHOR_POSITION = 'side_form_anchor_position';
    public const KEY_FIELDS = 'fields';
    public const KEY_SECTIONS = 'sections';

    public function setFormUpdatePath(string $formUpdatePath): self;
    
    public function getFormUpdatePath(): ?string;

    public function setIsSideFormAnchorEnable(bool $isSideFormAnchorEnable): self;

    public function isSideFormAnchorEnable(): ?bool;

    public function setSideFormAnchorPosition(string $sideFormAnchorPosition): self;

    public function getSideFormAnchorPosition(): ?string;

    public function getFormFieldFactory(): FormFieldFactoryInterface;

    public function getFormSectionFactory(): FormSectionFactoryInterface;

    /**
     * @return BaseSectionInterface[]
     */
    public function getSections(): array;

    /**
     * @param BaseSectionInterface[] $sections
     */
    public function setSections(array $sections): self;

    /**
     * @return BaseFieldInterface[]
     */
    public function getFields(): array;

    /**
     * @param BaseFieldInterface[] $fields
     * @return self
     */
    public function setFields(array $fields): self;

    /**
     * @param BaseFieldInterface[] $fields
     * @return self
     */
    public function addFields(array $fields): self;

    public function addIfNot(string $name, BaseFieldInterface $baseField): self;

    public function addField(string $name, BaseFieldInterface $baseField): self;

    public function removeField(string $name): self;

    public function resetData(array $data): self;
}
