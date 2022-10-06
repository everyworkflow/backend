<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\PageBuilderBundle\Block;

class MarkdownBlock extends ParagraphBlock implements MarkdownBlockInterface
{
    protected string $blockType = 'markdown_block';
}
