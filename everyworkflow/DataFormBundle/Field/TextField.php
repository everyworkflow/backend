<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataFormBundle\Field;

class TextField extends BaseField implements TextFieldInterface
{
    protected string $fieldType = 'text_field';

    public function getInputType(): ?string
    {
        return $this->dataObject->getData(self::KEY_INPUT_TYPE);
    }

    public function setInputType(string $inputType): self
    {
        $this->dataObject->setData(self::KEY_INPUT_TYPE, $inputType);
        return $this;
    }

    public function getSize(): ?string
    {
        return $this->dataObject->getData(self::KEY_SIZE);
    }

    public function setSize(string $size): self
    {
        $this->dataObject->setData(self::KEY_SIZE, $size);
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

    public function getPrefixText(): ?string
    {
        return $this->dataObject->getData(self::KEY_PREFIX_TEXT);
    }

    public function setPrefixText(string $prefixText): self
    {
        $this->dataObject->setData(self::KEY_PREFIX_TEXT, $prefixText);
        return $this;
    }

    public function getSuffixText(): ?string
    {
        return $this->dataObject->getData(self::KEY_SUFFIX_TEXT);
    }

    public function setSuffixText(string $suffixText): self
    {
        $this->dataObject->setData(self::KEY_SUFFIX_TEXT, $suffixText);
        return $this;
    }

    public function getPrefixTabText(): ?string
    {
        return $this->dataObject->getData(self::KEY_PREFIX_TAB_TEXT);
    }

    public function setPrefixTabText(string $prefixTabText): self
    {
        $this->dataObject->setData(self::KEY_PREFIX_TAB_TEXT, $prefixTabText);
        return $this;
    }

    public function getSuffixTabText(): ?string
    {
        return $this->dataObject->getData(self::KEY_SUFFIX_TAB_TEXT);
    }

    public function setSuffixTabText(string $suffixTabText): self
    {
        $this->dataObject->setData(self::KEY_SUFFIX_TAB_TEXT, $suffixTabText);
        return $this;
    }
}
