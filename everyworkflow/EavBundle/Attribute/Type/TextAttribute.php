<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Attribute\Type;

use EveryWorkflow\EavBundle\Attribute\BaseAttribute;

class TextAttribute extends BaseAttribute implements TextAttributeInterface
{
    protected string $attributeType = 'text_attribute';

    public function setMinLength(int $length): self
    {
        $this->dataObject->setData(self::KEY_MIN_LENGTH, $length);
        return $this;
    }

    public function getMinLength(): ?int
    {
        return $this->dataObject->getData(self::KEY_MIN_LENGTH);
    }

    public function setMaxLength(int $length): self
    {
        $this->dataObject->setData(self::KEY_MAX_LENGTH, $length);
        return $this;
    }

    public function getMaxLength(): ?int
    {
        return $this->dataObject->getData(self::KEY_MAX_LENGTH);
    }
}
