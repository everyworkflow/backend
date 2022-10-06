<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CoreBundle\Validation;

interface ValidatorInterface
{
    public function getValidData(): array;

    public function getAllErrors(): array;

    public function hasErrors(): bool;

    public function getRules(): array;

    public function setRules(array $rules): self;

    public function validate(mixed $data): bool;

    public function validateArray(array $data): bool;
}
