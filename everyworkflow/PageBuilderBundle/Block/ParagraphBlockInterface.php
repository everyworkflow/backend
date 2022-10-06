<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\PageBuilderBundle\Block;

interface ParagraphBlockInterface extends AbstractBlockInterface
{
    public const KEY_CONTENT = 'content';

    public function getContent(): string;

    public function setContent(string $content): self;
}
