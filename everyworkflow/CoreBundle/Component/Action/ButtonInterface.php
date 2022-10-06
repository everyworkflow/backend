<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CoreBundle\Component\Action;

use EveryWorkflow\CoreBundle\Support\ArrayableInterface;

interface ButtonInterface extends ArrayableInterface
{
    public const BUTTON_TYPE_DEFAULT = 'default';
    public const BUTTON_TYPE_TEXT = 'text';
    public const BUTTON_TYPE_LINK = 'link';
    public const BUTTON_TYPE_GHOST = 'ghost';
    public const BUTTON_TYPE_PRIMARY = 'primary';
    public const BUTTON_TYPE_DASHED = 'dashed';

    public const BUTTON_SIZE_SMALL = 'small';
    public const BUTTON_SIZE_MIDDLE = 'middle';
    public const BUTTON_SIZE_LARGE = 'large';

    public const BUTTON_SHAPE_CIRCLE = 'circle';
    public const BUTTON_SHAPE_ROUND = 'round';

    public const KEY_BUTTON_LABEL = 'button_label';
    public const KEY_BUTTON_PATH = 'button_path';
    public const KEY_BUTTON_TYPE = 'button_type';
    public const KEY_BUTTON_SIZE = 'button_size';
    public const KEY_BUTTON_SHAPE = 'button_shape';
    public const KEY_BUTTON_TARGET = 'button_target';
    public const KEY_IS_GHOST = 'is_ghost';
    public const KEY_IS_DANGER = 'is_danger';
    public const KEY_IS_BLOCK = 'is_block';
    public const KEY_CLASS_NAME = 'class_name';
    public const KEY_STYLE = 'style';
    
    public function setButtonLabel(string $buttonLabel): self;

    public function getButtonLabel(): ?string;

    public function setButtonPath(string $buttonPath): self;

    public function getButtonPath(): ?string;

    public function setButtonType(string $buttonType): self;

    public function getButtonType(): ?string;

    public function setButtonSize(string $buttonSize): self;

    public function getButtonSize(): ?string;

    public function setButtonShape(string $buttonShape): self;

    public function getButtonShape(): ?string;

    public function setButtonTarget(string $buttonTarget): self;

    public function getButtonTarget(): ?string;

    public function setIsGhost(bool $isGhost): self;

    public function isGhost(): bool;

    public function setIsDanger(bool $isDanger): self;

    public function isDanger(): bool;

    public function setIsBlock(bool $isBlock): self;

    public function isBlock(): bool;

    public function setClassName(string $className): self;

    public function getClassName(): ?string;

    public function setStyle(string $style): self;

    public function getStyle(): ?string;
}
