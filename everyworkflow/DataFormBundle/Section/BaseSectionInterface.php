<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataFormBundle\Section;

use EveryWorkflow\DataFormBundle\Model\FormInterface;

interface BaseSectionInterface extends FormInterface
{
    public const KEY_SORT_ORDER = 'sort_order';
    public const KEY_CODE = 'code';

    public function getSectionType(): string;

    public function getCode(): ?string;

    public function setCode(string $code): self;

    public function getSortOrder(): ?int;

    public function setSortOrder(int $sortOrder): self;

    public function resetData($data): self;
}
