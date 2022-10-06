<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Attribute\Type;

use EveryWorkflow\EavBundle\Attribute\BaseAttributeInterface;

interface TextAttributeInterface extends BaseAttributeInterface
{
    public const KEY_MIN_LENGTH = 'min_length';
    public const KEY_MAX_LENGTH = 'max_length';

    public function setMinLength(int $length): self;

    public function getMinLength(): ?int;

    public function setMaxLength(int $length): self;

    public function getMaxLength(): ?int;
}
