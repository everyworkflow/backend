<?php
/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CoreBundle\Validation\Type;

class NumberValidation extends AbstractValidation
{
    public const KEY_MINIUM = 'minimum';
    public const KEY_EXCLUSIVE_MINIUM = 'exclusive_minimum';
    public const KEY_MAXIMUM = 'maximum';
    public const KEY_EXCLUSIVE_MAXIMUM = 'exclusive_maximum';
    public const KEY_MULTIPLE_OF = 'multiple_of';

    public function setMinium(int|float $minimum): self
    {
        $this->setData(self::KEY_MINIUM, $minimum);

        return $this;
    }

    public function getMinium(): int|float|null
    {
        return $this->getData(self::KEY_MINIUM);
    }

    public function setExclusiveMinium(int|float $exclusiveMinimum): self
    {
        $this->setData(self::KEY_EXCLUSIVE_MINIUM, $exclusiveMinimum);

        return $this;
    }

    public function getExclusiveMinium(): int|float|null
    {
        return $this->getData(self::KEY_EXCLUSIVE_MINIUM);
    }

    public function setMaximum(int|float $maximum): self
    {
        $this->setData(self::KEY_MAXIMUM, $maximum);

        return $this;
    }

    public function getMaximum(): int|float|null
    {
        return $this->getData(self::KEY_MAXIMUM);
    }

    public function setExclusiveMaximum(int|float $exclusiveMaximum): self
    {
        $this->setData(self::KEY_EXCLUSIVE_MAXIMUM, $exclusiveMaximum);

        return $this;
    }

    public function getExclusiveMaximum(): int|float|null
    {
        return $this->getData(self::KEY_EXCLUSIVE_MAXIMUM);
    }

    public function setMultipleOf(int|float $multipleOf): self
    {
        $this->setData(self::KEY_MULTIPLE_OF, $multipleOf);

        return $this;
    }

    public function getMultipleOf(): int|float|null
    {
        return $this->getData(self::KEY_MULTIPLE_OF);
    }

    protected function validateMinMaxMultipleOf(int|float $value): ?bool
    {
        if (null !== $this->getMinium() && $value < $this->getMinium()) {
            $this->errorBag->addError(
                $this->getProperty(),
                sprintf('%s must be greater than or equal to %s.', $this->getPropertyName(), $this->getMinium())
            );

            return false;
        }

        if (null !== $this->getMaximum() && $value > $this->getMaximum()) {
            $this->errorBag->addError(
                $this->getProperty(),
                sprintf('%s must be less than or equal to %s.', $this->getPropertyName(), $this->getMaximum())
            );

            return false;
        }

        if (null !== $this->getExclusiveMinium() && $value <= $this->getExclusiveMinium()) {
            $this->errorBag->addError(
                $this->getProperty(),
                sprintf('%s must be greater than %s.', $this->getPropertyName(), $this->getExclusiveMinium())
            );

            return false;
        }

        if (null !== $this->getExclusiveMaximum() && $value >= $this->getExclusiveMaximum()) {
            $this->errorBag->addError(
                $this->getProperty(),
                sprintf('%s must be less than %s.', $this->getPropertyName(), $this->getExclusiveMaximum())
            );

            return false;
        }

        if (null !== $this->getMultipleOf() && 0 !== $value % $this->getMultipleOf()) {
            $this->errorBag->addError(
                $this->getProperty(),
                sprintf('%s must be a multiple of %s.', $this->getPropertyName(), $this->getMultipleOf())
            );

            return false;
        }

        return null;
    }

    protected function validateRequired($value): ?bool
    {
        if ($this->isRequired() && ('' === $value || null === $value)) {
            $this->errorBag->addError(
                $this->getProperty(),
                sprintf('%s is required.', $this->getPropertyName())
            );

            return false;
        }

        if (!is_numeric($value)) {
            $this->errorBag->addError(
                $this->getProperty(),
                sprintf('%s is not valid number.', $this->getPropertyName())
            );
            return false;
        }

        $value = $this->transform($value);

        if (!$this->isRequired() && empty($value)) {
            $this->setDefaultIfNot();

            return true;
        }

        return null;
    }

    protected function transform(mixed $value): mixed
    {
        if (!is_numeric($value)) {
            return 0;
        }

        if (intval($value) == $value) {
            $validValue = intval($value);
        } else {
            $validValue = floatval($value);
        }

        return $validValue;
    }

    protected function _validate(mixed $value): bool
    {
        $requiredResult = $this->validateRequired($value);
        if (null !== $requiredResult) {
            return $requiredResult;
        }

        $value = $this->transform($value);

        $minMaxMultipleOfResult = $this->validateMinMaxMultipleOf($value);
        if (null !== $minMaxMultipleOfResult) {
            return $minMaxMultipleOfResult;
        }

        $this->setValidData($value);

        return true;
    }
}
