<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CoreBundle\Validation;

interface ConfigurationInterface
{
    public function setRestrictMode(bool $restrictMode): self;

    public function isRestrictMode(): bool;

    public function setRules(array $rules): self;

    public function getRules(): array;

    public function setErrorBag(ErrorBagInterface $errorBag): self;

    public function getErrorBag(): ErrorBagInterface;

    public function setValidDataBag(ValidDataBagInterface $validDataBag): self;

    public function getValidDataBag(): ValidDataBagInterface;
}
