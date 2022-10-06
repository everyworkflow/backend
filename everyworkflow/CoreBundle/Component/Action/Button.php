<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CoreBundle\Component\Action;

use EveryWorkflow\CoreBundle\Model\DataObjectInterface;

class Button implements ButtonInterface
{
    protected DataObjectInterface $dataObject;

    public function __construct(DataObjectInterface $dataObject)
    {
        $this->dataObject = $dataObject;
    }

    public function setButtonLabel(string $buttonLabel): self
    {
        $this->dataObject->setData(self::KEY_BUTTON_LABEL, $buttonLabel);
        return $this;
    }

    public function getButtonLabel(): ?string
    {
        return $this->dataObject->getData(self::KEY_BUTTON_LABEL);
    }

    public function setButtonPath(string $buttonPath): self
    {
        $this->dataObject->setData(self::KEY_BUTTON_PATH, $buttonPath);
        return $this;
    }

    public function getButtonPath(): ?string
    {
        return $this->dataObject->getData(self::KEY_BUTTON_PATH);
    }

    public function setButtonType(string $buttonType): self
    {
        $this->dataObject->setData(self::KEY_BUTTON_TYPE, $buttonType);
        return $this;
    }

    public function getButtonType(): ?string
    {
        return $this->dataObject->getData(self::KEY_BUTTON_TYPE);
    }

    public function setButtonSize(string $buttonSize): self
    {
        $this->dataObject->setData(self::KEY_BUTTON_SIZE, $buttonSize);
        return $this;
    }

    public function getButtonSize(): ?string
    {
        return $this->dataObject->getData(self::KEY_BUTTON_SIZE);
    }

    public function setButtonShape(string $buttonShape): self
    {
        $this->dataObject->setData(self::KEY_BUTTON_SHAPE, $buttonShape);
        return $this;
    }

    public function getButtonShape(): ?string
    {
        return $this->dataObject->getData(self::KEY_BUTTON_SHAPE);
    }

    public function setButtonTarget(string $buttonTarget): self
    {
        $this->dataObject->setData(self::KEY_BUTTON_TARGET, $buttonTarget);
        return $this;
    }

    public function getButtonTarget(): ?string
    {
        return $this->dataObject->getData(self::KEY_BUTTON_TARGET);
    }

    public function setIsGhost(bool $isGhost): self
    {
        $this->dataObject->setData(self::KEY_IS_GHOST, $isGhost);
        return $this;
    }

    public function isGhost(): bool
    {
        return $this->dataObject->getData(self::KEY_IS_GHOST) ?? false;
    }

    public function setIsDanger(bool $isDanger): self
    {
        $this->dataObject->setData(self::KEY_IS_DANGER, $isDanger);
        return $this;
    }

    public function isDanger(): bool
    {
        return $this->dataObject->getData(self::KEY_IS_DANGER) ?? false;
    }

    public function setIsBlock(bool $isBlock): self
    {
        $this->dataObject->setData(self::KEY_IS_BLOCK, $isBlock);
        return $this;
    }

    public function isBlock(): bool
    {
        return $this->dataObject->getData(self::KEY_IS_BLOCK) ?? false;
    }

    public function setClassName(string $className): self
    {
        $this->dataObject->setData(self::KEY_CLASS_NAME, $className);
        return $this;
    }

    public function getClassName(): ?string
    {
        return $this->dataObject->getData(self::KEY_CLASS_NAME);
    }

    public function setStyle(string $style): self
    {
        $this->dataObject->setData(self::KEY_STYLE, $style);
        return $this;
    }

    public function getStyle(): ?string
    {
        return $this->dataObject->getData(self::KEY_STYLE);
    }

    public function toArray(): array
    {
        return $this->dataObject->toArray();
    }
}
