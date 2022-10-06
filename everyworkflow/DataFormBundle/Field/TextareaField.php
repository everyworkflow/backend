<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataFormBundle\Field;

class TextareaField extends BaseField implements TextareaFieldInterface
{
    protected string $fieldType = 'textarea_field';

    public function getRowCount(): ?int
    {
        return $this->dataObject->getData(self::KEY_ROW_COUNT);
    }

    public function setRowCount(int $rowCount): self
    {
        $this->dataObject->setData(self::KEY_ROW_COUNT, $rowCount);
        return $this;
    }

    public function isReadonlyText(): ?bool
    {
        return (bool) $this->dataObject->getData(self::KEY_IS_READONLY_TEXT);
    }

    public function setIsReadonlyText(bool $isReadonlyText): self
    {
        $this->dataObject->setData(self::KEY_IS_READONLY_TEXT, $isReadonlyText);
        return $this;
    }
}
