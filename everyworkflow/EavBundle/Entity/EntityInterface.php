<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Entity;

use EveryWorkflow\CoreBundle\Support\ArrayableInterface;
use EveryWorkflow\EavBundle\Attribute\BaseAttributeInterface;

interface EntityInterface extends ArrayableInterface
{
    public const KEY_ID = '_id';
    public const KEY_CODE = 'code';
    public const KEY_CLASS = 'class';
    public const KEY_NAME = 'name';

    public function getId(): ?string;

    public function setCode(string $code): self;

    public function getCode(): ?string;

    public function setClass(string $class): self;

    public function getClass(): ?string;

    public function setName(string $name): self;

    public function getName(): ?string;

    /**
     * @param BaseAttributeInterface[]
     * @return Entity
     */
    public function setAttributes(array $attributes): self;

    /**
     * @return BaseAttributeInterface[]
     */
    public function getAttributes(): array;
}
