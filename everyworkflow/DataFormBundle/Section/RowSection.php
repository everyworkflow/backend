<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataFormBundle\Section;

class RowSection extends BaseSection implements RowSectionInterface
{
    protected string $sectionType = 'row_section';

    public function setAlign(string $align): self
    {
        $this->dataObject->setData(self::KEY_ALIGN, $align);
        return $this;
    }

    public function getAlign(): ?string
    {
        return $this->dataObject->getData(self::KEY_ALIGN);
    }

    public function setGutter(string|int $gutter): self
    {
        $this->dataObject->setData(self::KEY_GUTTER, $gutter);
        return $this;
    }

    public function getGutter(): string|int|null
    {
        return $this->dataObject->getData(self::KEY_GUTTER);
    }

    public function setJustify(string $justify): self
    {
        $this->dataObject->setData(self::KEY_JUSTIFY, $justify);
        return $this;
    }

    public function getJustify(): ?string
    {
        return $this->dataObject->getData(self::KEY_JUSTIFY);
    }

    public function setWrap(bool $wrap): self
    {
        $this->dataObject->setData(self::KEY_WRAP, $wrap);
        return $this;
    }

    public function isWrap(): ?bool
    {
        return $this->dataObject->getData(self::KEY_WRAP);
    }
}
