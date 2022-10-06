<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataFormBundle\Field;

use EveryWorkflow\DataFormBundle\Field\Select\OptionInterface;

interface RadioFieldInterface extends BaseFieldInterface
{
    public const KEY_OPTIONS = 'options';

    /**
     * @return OptionInterface[]
     */
    public function getOptions(): array;

    /**
     * @param OptionInterface[] $options
     * @return self
     */
    public function setOptions(array $options): self;
}
