<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataFormBundle\Field;

interface SwitchFieldInterface extends BaseFieldInterface
{
    public const KEY_CHECKED_LABEL = 'checked_label';
    public const KEY_UNCHECKED_LABEL = 'unchecked_label';

    public function getCheckedLabel(): ?string;

    public function setCheckedLabel(string $checkedLabel): self;

    public function getUnCheckedLabel(): ?string;

    public function setUnCheckedLabel(string $unCheckedLabel): self;
}
