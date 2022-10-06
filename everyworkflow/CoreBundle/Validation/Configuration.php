<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CoreBundle\Validation;

class Configuration implements ConfigurationInterface
{
    protected bool $restrictMode;
    protected array $rules;

    protected ErrorBagInterface $errorBag;
    protected ValidDataBagInterface $validDataBag;

    public function __construct(
        ErrorBagInterface $errorBag,
        ValidDataBagInterface $validDataBag,
        array $rules = [],
        $restrictMode = false
    ) {
        $this->errorBag = $errorBag;
        $this->validDataBag = $validDataBag;
        $this->rules = $rules;
        $this->restrictMode = $restrictMode;
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
