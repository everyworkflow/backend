<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataFormBundle\Field;

use EveryWorkflow\CoreBundle\Support\ArrayableInterface;

interface BaseFieldInterface extends ArrayableInterface
{
    public const KEY_ID = '_id';
    public const KEY_LABEL = 'label';
    public const KEY_NAME = 'name';
    public const KEY_VALUE = 'value';
    public const KEY_SORT_ORDER = 'sort_order';
    public const KEY_HELP_TEXT = 'help_text';
    public const KEY_DEFAULT_VALUE = 'default_value';
    public const KEY_IS_REQUIRED = 'is_required';
    public const KEY_IS_DISABLED = 'is_disabled';
    public const KEY_IS_READONLY = 'is_readonly';

    public function getFieldType(): string;

    public function getId(): ?string;

    public function setId(string $id): self;

    public function getLabel(): ?string;

    public function setLabel(string $label): self;

    public function getName(): ?string;

    public function setName(string $name): self;

    public function getValue(): mixed;

    public function setValue(mixed $value): self;

    public function getSortOrder(): ?int;

    public function setSortOrder(int $sortOrder): self;

    public function getHelpText(): ?string;

    public function setHelpText(string $helpText): self;

    public function getDefaultValue(): mixed;

    public function setDefaultValue(mixed $defaultValue): self;

    public function isRequired(): ?bool;

    public function setIsRequired(bool $isRequired): self;

    public function isDisabled(): ?bool;

    public function setIsDisabled(bool $isDisabled): self;

    public function isReadonly(): ?bool;

    public function setIsReadonly(bool $isReadonly): self;

    public function resetData($data): self;
}
