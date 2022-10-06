<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataFormBundle\Field;

use EveryWorkflow\DataFormBundle\Field\Trait\ClearableTraitInterface;

interface DatePickerFieldInterface extends BaseFieldInterface, ClearableTraitInterface
{
    public const KEY_PICKER = 'picker';
    public const KEY_FORMAT = 'format';

    public const PICKER_WEEK = 'week';
    public const PICKER_MONTH = 'month';
    public const PICKER_QUARTER = 'quarter';
    public const PICKER_YEAR = 'year';

    public function getPicker(): string;

    public function setPicker(string $picker): self;

    public function getFormat(): string;

    public function setFormat(string $format): self;
}
