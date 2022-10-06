<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataFormBundle\Factory;

use EveryWorkflow\DataFormBundle\Section\BaseSectionInterface;

interface FormSectionFactoryInterface
{
    public function createFromClassName(string $className, array $data = []): ?BaseSectionInterface;

    public function createFromType(string $sectionType, array $data = []): ?BaseSectionInterface;

    public function create(array $data = []): ?BaseSectionInterface;
}
