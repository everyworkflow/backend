<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\PageBuilderBundle\Block;

class ParagraphBlock extends AbstractBlock implements ParagraphBlockInterface
{
    protected string $blockType = 'paragraph_block';

    public function getContent(): string
    {
        return $this->dataObject->getData(self::KEY_CONTENT);
    }

    public function setContent(string $content): self
    {
        $this->dataObject->setData(self::KEY_CONTENT, $content);
        return $this;
    }
}
