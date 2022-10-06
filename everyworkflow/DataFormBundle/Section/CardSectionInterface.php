<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataFormBundle\Section;

interface CardSectionInterface extends BaseSectionInterface
{
    public const KEY_TITLE = 'title';
    public const KEY_DESCRIPTION = 'description';

    public function setTitle(string $title): self;

    public function getTitle(): ?string;

    public function setDescription(string $description): self;

    public function getDescription(): ?string;
}
