<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CoreBundle\Validation;

class Configuration implements ConfigurationInterface
{
    /**
     * @param array<int,mixed> $rules
     */
    public function __construct(
        protected ErrorBagInterface $errorBag,
        protected ValidDataBagInterface $validDataBag,
        protected array $rules = [],
        protected bool $restrictMode = false
    ) {
    }

    public function setRestrictMode(bool $restrictMode): self
    {
        $this->restrictMode = $restrictMode;

        return $this;
    }

    public function isRestrictMode(): bool
    {
        return $this->restrictMode;
    }

    public function setRules(array $rules): self
    {
        $this->rules = $rules;

        return $this;
    }

    public function getRules(): array
    {
        return $this->rules;
    }

    public function setErrorBag(ErrorBagInterface $errorBag): self
    {
        $this->errorBag = $errorBag;

        return $this;
    }

    public function getErrorBag(): ErrorBagInterface
    {
        return $this->errorBag;
    }

    public function setValidDataBag(ValidDataBagInterface $validDataBag): self
    {
        $this->validDataBag = $validDataBag;

        return $this;
    }

    public function getValidDataBag(): ValidDataBagInterface
    {
        return $this->validDataBag;
    }
}
