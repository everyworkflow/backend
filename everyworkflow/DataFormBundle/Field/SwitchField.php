<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataFormBundle\Field;

class SwitchField extends BaseField implements SwitchFieldInterface
{
    protected string $fieldType = 'switch_field';

    public function getCheckedLabel(): ?string
    {
        return $this->dataObject->getData(self::KEY_CHECKED_LABEL);
    }

    public function setCheckedLabel(string $checkedLabel): self
    {
        $this->dataObject->setData(self::KEY_CHECKED_LABEL, $checkedLabel);
        return $this;
    }

    public function getUnCheckedLabel(): ?string
    {
        return $this->dataObject->getData(self::KEY_UNCHECKED_LABEL);
    }

    public function setUnCheckedLabel(string $unCheckedLabel): self
    {
        $this->dataObject->setData(self::KEY_UNCHECKED_LABEL, $unCheckedLabel);
        return $this;
    }
}
