<?php
/**
 * @copyright EveryWorkflow. All rights reserved.
 */

namespace EveryWorkflow\DataFormBundle\Field\Trait;

interface ClearableTraitInterface
{
    public const KEY_ALLOW_CLEAR = 'allow_clear';

    public function allowClear(): bool;

    public function setAllowClear(bool $allowClear): self;
}
