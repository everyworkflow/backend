<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\PageBuilderBundle\Block;

use EveryWorkflow\CoreBundle\Model\DataObjectInterface;

class AbstractBlock implements AbstractBlockInterface
{
    protected string $blockType = 'abstract_block';

    public function __construct(
        protected DataObjectInterface $dataObject
    ) {
    }

    public function getBlockType(): string
    {
        return $this->blockType;
    }

    public function getStyle(): array
    {
        return $this->dataObject->getData(self::KEY_STYLE) ?? [];
    }

    public function setStyle(array $style): self
    {
        $this->dataObject->setData(self::KEY_STYLE, $style);

        return $this;
    }

    public function toArray(): array
    {
        $data = $this->dataObject->toArray();
        $data[self::KEY_BLOCK_TYPE] = $this->getBlockType();

        return $data;
    }
}
