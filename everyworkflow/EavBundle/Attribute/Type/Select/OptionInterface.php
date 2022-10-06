<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Attribute\Type\Select;

use EveryWorkflow\CoreBundle\Support\ArrayableInterface;

interface OptionInterface extends ArrayableInterface
{
    public const KEY_KEY = 'key';
    public const KEY_VALUE = 'value';
    public const KEY_SORT_ORDER = 'sort_order';

    public function setKey(string $key): self;

    public function getKey(): ?string;

    public function setValue(string $val): self;

    public function getValue(): ?string;

    public function setSortOrder(int $sortOrder): self;

    public function getSortOrder(): ?int;
}
