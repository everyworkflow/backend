<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\PageBuilderBundle\Factory;

use EveryWorkflow\DataFormBundle\Model\FormInterface;

interface BlockFormFactoryInterface
{
    public function createFormForBlockType(string $blockType): FormInterface;
}
