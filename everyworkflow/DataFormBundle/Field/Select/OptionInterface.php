<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataFormBundle\Field\Select;

use EveryWorkflow\CoreBundle\Support\ArrayableInterface;

interface OptionInterface extends ArrayableInterface
{
    public const KEY_KEY = 'key';
    public const KEY_IS_ENABLED = 'is_enabled';
    public const KEY_VALUE = 'value';
    public const KEY_SORT_ORDER = 'sort_order';
    public const KEY_CHILDREN = 'children';

    public function setKey(string $key): self;

    public function getKey(): ?string;

    public function setIsEnabled(bool $isEnabled): self;

    public function getIsEnabled(): ?bool;

    public function setValue(string $val): self;

    public function getValue(): ?string;

    public function setSortOrder(int $sortOrder): self;

    public function getSortOrder(): ?int;

    public function setChildren(array $children): self;

    public function getChildren(): array;
}
