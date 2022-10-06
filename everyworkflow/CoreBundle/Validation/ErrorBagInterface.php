<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CoreBundle\Validation;

use EveryWorkflow\CoreBundle\Model\DataObjectInterface;

interface ErrorBagInterface extends DataObjectInterface
{
    public function getAllErrors(): array;

    /**
     * @return string[]
     */
    public function getErrors(string $property): array;

    /**
     * @param string[] $messages
     */
    public function setErrors(string $property, array $messages): self;

    public function addError(string $property, string $message): self;

    public function clear(): self;
}
