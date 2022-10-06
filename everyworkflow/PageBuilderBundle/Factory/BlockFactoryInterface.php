<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\PageBuilderBundle\Factory;

use EveryWorkflow\PageBuilderBundle\Block\AbstractBlockInterface;

interface BlockFactoryInterface
{
    public function create(string $className, array $data): AbstractBlockInterface;

    public function createBlockFromType(string $blockType, array $data): AbstractBlockInterface;

    public function createBlock(array $data): AbstractBlockInterface;
}
