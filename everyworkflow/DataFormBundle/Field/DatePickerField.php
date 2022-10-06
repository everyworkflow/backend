<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataFormBundle\Field;

use EveryWorkflow\DataFormBundle\Field\Trait\ClearableTrait;

class DatePickerField extends BaseField implements DatePickerFieldInterface
{
    use ClearableTrait;

    protected string $fieldType = 'date_picker_field';

    public function getPicker(): string
    {
        return $this->dataObject->getData(self::KEY_PICKER);
    }

    public function setPicker(string $picker): self
    {
        $this->dataObject->setData(self::KEY_PICKER, $picker);
        return $this;
    }

    public function getFormat(): string
    {
        return $this->dataObject->getData(self::KEY_FORMAT);
    }

    public function setFormat(string $format): self
    {
        $this->dataObject->setData(self::KEY_FORMAT, $format);
        return $this;
    }
}
