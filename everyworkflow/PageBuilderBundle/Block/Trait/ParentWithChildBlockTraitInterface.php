<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\PageBuilderBundle\Block\Trait;

use EveryWorkflow\PageBuilderBundle\Block\AbstractBlockInterface;

interface ParentWithChildBlockTraitInterface
{
    public function addBlock(string $id, AbstractBlockInterface $block): self;

    public function removeBlock(string $id): self;

    public function getBlocks(): array;

    public function setBlocks(array $blocks): self;
}
