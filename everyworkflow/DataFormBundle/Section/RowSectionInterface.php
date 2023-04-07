<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataFormBundle\Section;

interface RowSectionInterface extends BaseSectionInterface
{
    public const KEY_ALIGN = 'align';
    public const KEY_GUTTER = 'gutter';
    public const KEY_JUSTIFY = 'justify';
    public const KEY_WRAP = 'wrap';

    public function setAlign(string $align): self;

    public function getAlign(): ?string;

    public function setGutter(string|int $gutter): self;

    public function getGutter(): string|int|null;

    public function setJustify(string $justify): self;

    public function getJustify(): ?string;

    public function setWrap(bool $wrap): self;

    public function isWrap(): ?bool;
}
