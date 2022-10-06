<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataGridBundle\Model;

use EveryWorkflow\CoreBundle\Component\Action\ButtonInterface;

interface ActionInterface extends ButtonInterface
{
    public const PATH_TYPE_ROUTE = ''; // default
    public const PATH_TYPE_POST_CALL = 'post_call';
    public const PATH_TYPE_DELETE_CALL = 'delete_call';
    public const PATH_TYPE_EXTERNAL = 'external';
    public const PATH_TYPE_POPUP_FORM = 'popup_form';

    public const KEY_ACTION_TYPE = 'action_type';
    public const KEY_NAME = 'name';
    public const KEY_PATH_TYPE = 'path_type';
    public const KEY_IS_CONFIRM = 'is_confirm';
    public const KEY_CONFIRM_MESSAGE = 'confirm_message';
    public const KEY_ICON_SVG = 'icon_svg';

    public function getActionType(): ?string;

    public function setName(string $name): self;

    public function getName(): ?string;

    public function setPathType(string $pathType): self;

    public function getPathType(): ?string;

    public function setIsConfirm(bool $confirm): self;

    public function isConfirm(): bool;

    public function setConfirmMessage(string $message): self;

    public function getConfirmMessage(): ?string;

    public function setIconSvg(string $iconSvg): self;

    public function getIconSvg(): ?string;
}
