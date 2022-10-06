<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\PageBuilderBundle\Block;

interface HeadingBlockInterface extends AbstractBlockInterface
{
    public const HEADING_TYPE_H1 = 'h1'; // default
    public const HEADING_TYPE_H2 = 'h2';
    public const HEADING_TYPE_H3 = 'h3';
    public const HEADING_TYPE_H4 = 'h4';
    public const HEADING_TYPE_H5 = 'h5';

    public const KEY_HEADING = 'heading';
    public const KEY_SUB_HEADING = 'sub_heading';
    public const KEY_HEADING_TYPE = 'heading_type';

    public function getHeading(): string;

    public function setHeading(string $heading): self;

    public function getSubHeading(): ?string;

    public function setSubHeading(string $subHeading): self;

    public function getHeadingType(): ?string;

    public function setHeadingType(string $headingType): self;
}
