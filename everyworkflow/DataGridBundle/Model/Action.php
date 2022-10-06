<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataGridBundle\Model;

use EveryWorkflow\CoreBundle\Model\DataObjectInterface;
use EveryWorkflow\CoreBundle\Component\Action\Button;

class Action extends Button implements ActionInterface
{
    protected string $actionType = 'link';

    /**
     * @var DataObjectInterface
     */
    protected DataObjectInterface $dataObject;

    public function __construct(DataObjectInterface $dataObject)
    {
        $this->dataObject = $dataObject;
    }

    public function getActionType(): ?string
    {
        return $this->actionType;
    }

    public function setName(string $name): self
    {
        $this->dataObject->setData(self::KEY_NAME, $name);
        return $this;
    }

    public function getName(): ?string
    {
        return $this->dataObject->getData(self::KEY_NAME);
    }

    public function setPathType(string $pathType): self
    {
        $this->dataObject->setData(self::KEY_PATH_TYPE, $pathType);
        return $this;
    }

    public function getPathType(): ?string
    {
        return $this->dataObject->getData(self::KEY_PATH_TYPE);
    }

    public function setIsConfirm(bool $confirm): self
    {
        $this->dataObject->setData(self::KEY_IS_CONFIRM, $confirm);
        return $this;
    }

    public function isConfirm(): bool
    {
        return $this->dataObject->getData(self::KEY_IS_CONFIRM) ?? false;
    }

    public function setConfirmMessage(string $message): self
    {
        $this->dataObject->setData(self::KEY_CONFIRM_MESSAGE, $message);
        return $this;
    }

    public function getConfirmMessage(): ?string
    {
        return $this->dataObject->getData(self::KEY_CONFIRM_MESSAGE);
    }

    public function setIconSvg(string $iconSvg): self
    {
        $this->dataObject->setData(self::KEY_ICON_SVG, $iconSvg);
        return $this;
    }

    public function getIconSvg(): ?string
    {
        return $this->dataObject->getData(self::KEY_ICON_SVG);
    }

    public function setActionTarget(string $actionTarget): self
    {
        $this->dataObject->setData(self::KEY_ACTION_TARGET, $actionTarget);

        return $this;
    }

    public function getActionTarget(): ?string
    {
        return $this->dataObject->getData(self::KEY_ACTION_TARGET);
    }

    public function toArray(): array
    {
        $data = parent::toArray();
        $data[self::KEY_ACTION_TYPE] = $this->getActionType();
        if ($this->isConfirm() && !$this->getConfirmMessage()) {
            $data[self::KEY_CONFIRM_MESSAGE] = 'Are you sure?';
        }
        return $data;
    }
}
