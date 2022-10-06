<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataGridBundle\Model;

use EveryWorkflow\CoreBundle\Support\ArrayableInterface;

interface DataGridColumnInterface extends ArrayableInterface
{
    public const KEY_NAME = 'name';
    public const KEY_SORT_ORDER = 'sort_order';
    public const KEY_IS_ACTIVE = 'is_active';
    public const KEY_IS_SORTABLE = 'is_sortable';
    public const KEY_IS_FILTERABLE = 'is_filterable';

    public function getName(): ?string;

    public function setName(string $name): self;

    public function getSortOrder(): ?int;

    public function setSortOrder(int $sortOrder): self;

    public function getIsActive(): bool;

    public function setIsActive(bool $isActive): self;

    public function getIsSortable(): bool;

    public function setIsSortable(bool $isSortable): self;

    public function getIsFilterable(): bool;

    public function setIsFilterable(bool $isFilterable): self;
}
