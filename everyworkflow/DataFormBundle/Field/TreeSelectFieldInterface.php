<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataFormBundle\Field;

use EveryWorkflow\DataFormBundle\Field\Select\OptionInterface;

interface TreeSelectFieldInterface extends BaseFieldInterface
{
    public const KEY_IS_SEARCHABLE = 'is_searchable';
    public const KEY_OPTIONS = 'options';

    public function isSearchable(): bool;

    public function setIsSearchable(bool $isSearchable): self;

    /**
     * @return OptionInterface[]
     */
    public function getOptions(): array;

    /**
     * @param OptionInterface[] $options
     * @return self
     */
    public function setOptions(array $options): self;
}
