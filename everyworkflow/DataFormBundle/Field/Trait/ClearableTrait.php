<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

namespace EveryWorkflow\DataFormBundle\Field\Trait;

trait ClearableTrait
{
    public function allowClear(): bool
    {
        return $this->dataObject->getData(self::KEY_ALLOW_CLEAR);
    }

    public function setAllowClear(bool $allowClear): self
    {
        $this->dataObject->setData(self::KEY_ALLOW_CLEAR, $allowClear);

        return $this;
    }
}
