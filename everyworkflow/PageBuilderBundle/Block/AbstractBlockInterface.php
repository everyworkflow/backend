<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\PageBuilderBundle\Block;

use EveryWorkflow\CoreBundle\Support\ArrayableInterface;

interface AbstractBlockInterface extends ArrayableInterface
{
    public const KEY_BLOCK_TYPE = 'block_type';
    public const KEY_STYLE = 'style';
    public const KEY_BLOCK_DATA = 'block_data';

    public function getBlockType(): string;

    public function getStyle(): array;

    public function setStyle(array $style): self;
}
