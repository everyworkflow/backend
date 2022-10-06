<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\PageBuilderBundle\Form\Block;

use EveryWorkflow\DataFormBundle\Model\FormInterface;

interface AbstractBlockFormInterface extends FormInterface
{
    public const PANEL_SIZE_FULL = 'panel_full_size';
    public const PANEL_SIZE_HALF = 'panel_half_size';
    public const PANEL_SIZE_SMALL = 'panel_small_size';
    public const PANEL_SIZE_MEDIUM = 'panel_medium_size';

    public const KEY_PANEL_SIZE = 'panel_size';

    public function getPanelSize(): string;
    public function setPanelSize(string $panelSize): self;
}
