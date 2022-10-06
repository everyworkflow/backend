<?php
/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CoreBundle\Validation\Type;

class BooleanValidation extends AbstractValidation
{
    protected function validateRequired($value): ?bool
    {
        if ($this->isRequired() && ('' === $value || null === $value)) {
            $this->errorBag->addError(
                $this->getProperty(),
                sprintf('%s is required.', $this->getPropertyName())
            );

            return false;
        }

        if (!$this->isRequired() && empty($value)) {
            $this->setDefaultIfNot();

            return true;
        }

        return null;
    }

    protected function transform(mixed $value): mixed
    {
        $validValue = 'false' === $value ? false : (bool) $value;

        return $validValue;
    }

    protected function _validate(mixed $value): bool
    {
        $requiredResult = $this->validateRequired($value);
        if (null !== $requiredResult) {
            return $requiredResult;
        }

        $value = $this->transform($value);

        $this->setValidData($value);

        return true;
    }
}
