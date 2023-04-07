<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataFormBundle\Section;

class ColSection extends BaseSection implements ColSectionInterface
{
    protected string $sectionType = 'col_section';

    public function setFlex(string|int $flex): self
    {
        $this->dataObject->setData(self::KEY_FLEX, $flex);

        return $this;
    }

    public function getFlex(): string|int|null
    {
        return $this->dataObject->getData(self::KEY_FLEX);
    }

    public function setOffset(string|int $offset): self
    {
        $this->dataObject->setData(self::KEY_OFFSET, $offset);

        return $this;
    }

    public function getOffset(): string|int|null
    {
        return $this->dataObject->getData(self::KEY_OFFSET);
    }

    public function setOrder(string|int $order): self
    {
        $this->dataObject->setData(self::KEY_ORDER, $order);

        return $this;
    }

    public function getOrder(): string|int|null
    {
        return $this->dataObject->getData(self::KEY_ORDER);
    }

    public function setPull(string|int $pull): self
    {
        $this->dataObject->setData(self::KEY_PULL, $pull);

        return $this;
    }

    public function getPull(): string|int|null
    {
        return $this->dataObject->getData(self::KEY_PULL);
    }

    public function setPush(string|int $push): self
    {
        $this->dataObject->setData(self::KEY_PUSH, $push);

        return $this;
    }

    public function getPush(): string|int|null
    {
        return $this->dataObject->getData(self::KEY_PUSH);
    }

    public function setSpan(string|int $span): self
    {
        $this->dataObject->setData(self::KEY_SPAN, $span);

        return $this;
    }

    public function getSpan(): string|int|null
    {
        return $this->dataObject->getData(self::KEY_SPAN);
    }
}
