<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\PageBuilderBundle\Block\Trait;

use EveryWorkflow\PageBuilderBundle\Block\AbstractBlockInterface;

trait ParentWithChildBlockTrait
{
    /**
     * @var AbstractBlockInterface[]
     */
    protected array $blocks = [];

    public function addBlock(string $id, AbstractBlockInterface $block): self
    {
        $this->blocks[$id] = $block;

        return $this;
    }

    public function removeBlock(string $id): self
    {
        if (isset($this->blocks[$id])) {
            unset($this->blocks[$id]);
        }

        return $this;
    }

    public function getBlocks(): array
    {
        return $this->blocks;
    }

    public function setBlocks(array $blocks): self
    {
        $this->blocks = $blocks;

        return $this;
    }
}
