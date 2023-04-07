<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataFormBundle\Section;

interface ColSectionInterface extends BaseSectionInterface
{
    public const KEY_FLEX = 'flex';
    public const KEY_OFFSET = 'offset';
    public const KEY_ORDER = 'order';
    public const KEY_PULL = 'pull';
    public const KEY_PUSH = 'push';
    public const KEY_SPAN = 'span';

    public function setFlex(string|int $flex): self;

    public function getFlex(): string|int|null;

    public function setOffset(string|int $offset): self;

    public function getOffset(): string|int|null;

    public function setOrder(string|int $order): self;

    public function getOrder(): string|int|null;

    public function setPull(string|int $pull): self;

    public function getPull(): string|int|null;

    public function setPush(string|int $push): self;

    public function getPush(): string|int|null;

    public function setSpan(string|int $span): self;

    public function getSpan(): string|int|null;
}
