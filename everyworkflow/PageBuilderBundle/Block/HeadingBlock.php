<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\PageBuilderBundle\Block;

use EveryWorkflow\CoreBundle\Model\DataObjectInterface;

class HeadingBlock extends AbstractBlock implements HeadingBlockInterface
{
    protected string $blockType = 'heading_block';

    public function __construct(DataObjectInterface $dataObject)
    {
        parent::__construct($dataObject);
        $this->dataObject->setDataIfNot(self::KEY_HEADING_TYPE, self::HEADING_TYPE_H1);
    }

    public function getHeading(): string
    {
        return $this->dataObject->getData(self::KEY_HEADING) ?? '';
    }

    public function setHeading(string $heading): self
    {
        $this->dataObject->setData(self::KEY_HEADING, $heading);

        return $this;
    }

    public function getSubHeading(): ?string
    {
        return $this->dataObject->getData(self::KEY_SUB_HEADING) ?? '';
    }

    public function setSubHeading(string $subHeading): self
    {
        $this->dataObject->setData(self::KEY_SUB_HEADING, $subHeading);

        return $this;
    }

    public function getHeadingType(): ?string
    {
        return $this->dataObject->getData(self::KEY_HEADING_TYPE) ?? self::HEADING_TYPE_H1;
    }

    public function setHeadingType(string $headingType): self
    {
        $this->dataObject->setData(self::KEY_HEADING_TYPE, $headingType);

        return $this;
    }
}
