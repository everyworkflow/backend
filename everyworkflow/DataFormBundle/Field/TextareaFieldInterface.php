<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataFormBundle\Field;

interface TextareaFieldInterface extends BaseFieldInterface
{
    public const KEY_ROW_COUNT = 'row_count';
    public const KEY_IS_READONLY_TEXT = 'is_readonly_text';

    public function getRowCount(): ?int;
    public function setRowCount(int $rowCount): self;

    public function isReadonlyText(): ?bool;
    public function setIsReadonlyText(bool $isReadonlyText): self;
}
