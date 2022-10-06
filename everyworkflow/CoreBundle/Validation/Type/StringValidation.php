<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CoreBundle\Validation\Type;

use Exception;

class StringValidation extends AbstractValidation
{
    public const KEY_MIN_LENGTH = 'min_length';
    public const KEY_MAX_LENGTH = 'max_length';
    public const KEY_PATTERN = 'pattern';

    public function setMinLength(int $minLength): self
    {
        $this->setData(self::KEY_MIN_LENGTH, $minLength);

        return $this;
    }

    public function getMinLength(): ?int
    {
        return $this->getData(self::KEY_MIN_LENGTH);
    }

    public function setMaxLength(int $maxLength): self
    {
        $this->setData(self::KEY_MAX_LENGTH, $maxLength);

        return $this;
    }

    public function getMaxLength(): ?int
    {
        return $this->getData(self::KEY_MAX_LENGTH);
    }

    public function setPattern(string $pattern): self
    {
        $this->setData(self::KEY_PATTERN, $pattern);

        return $this;
    }

    public function getPattern(): ?string
    {
        return $this->getData(self::KEY_PATTERN);
    }

    protected function validateRequired($value): ?bool
    {
        if ($this->isRequired() && $value === '') {
            $this->errorBag->addError(
                $this->getProperty(),
                sprintf('%s is required.', $this->getPropertyName())
            );

            return false;
        }

        if (!$this->isRequired() && $value === '') {
            $this->setDefaultIfNot();

            return true;
        }

        return null;
    }

    protected function validateLength($value): ?bool
    {
        if (null !== $this->getMinLength() && strlen($value) < $this->getMinLength()) {
            $this->errorBag->addError(
                $this->getProperty(),
                sprintf(
                    '%s length must be greater than or equal to %s.',
                    $this->getPropertyName(),
                    $this->getMinLength()
                )
            );

            return false;
        }

        if (null !== $this->getMaxLength() && strlen($value) > $this->getMaxLength()) {
            $this->errorBag->addError(
                $this->getProperty(),
                sprintf(
                    '%s length must be less than or equal to %s.',
                    $this->getPropertyName(),
                    $this->getMaxLength()
                )
            );

            return false;
        }

        return null;
    }

    protected function transform(mixed $value): mixed
    {
        $validValue = (string) $value;

        return $validValue;
    }

    protected function _validate(mixed $value): bool
    {
        try {
            $value = $this->transform($value);
        } catch (Exception $e) {
            $this->errorBag->addError(
                $this->getProperty(),
                sprintf(
                    '%s must be a string.',
                    $this->getPropertyName()
                )
            );

            return false;
        }

        $requiredResult = $this->validateRequired($value);
        if (null !== $requiredResult) {
            return $requiredResult;
        }

        if (null !== $this->getPattern() && !preg_match($this->getPattern(), $value)) {
            $this->errorBag->addError(
                $this->getProperty(),
                sprintf(
                    '%s is not valid.',
                    $this->getPropertyName()
                )
            );

            return false;
        }

        $lengthResult = $this->validateLength($value);
        if (null !== $lengthResult) {
            return $lengthResult;
        }

        $this->setValidData($value);

        return true;
    }
}
