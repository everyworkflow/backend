<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CoreBundle\Validation\Type;

use EveryWorkflow\CoreBundle\Factory\ValidationTypeFactoryInterface;
use Symfony\Contracts\Service\Attribute\Required;

class ArrayValidation extends AbstractValidation
{
    protected ValidationTypeFactoryInterface $validationTypeFactory;

    #[Required]
    public function setValidationTypeFactory(ValidationTypeFactoryInterface $validationTypeFactory): self
    {
        $this->validationTypeFactory = $validationTypeFactory;

        return $this;
    }

    public function getRules(): array
    {
        $rules = $this->configuration->getRules();

        if ($this->getProperty() === '') {
            return $rules;
        }

        $indexes = explode('.', $this->getProperty());
        if (count($indexes) === 1 && isset($rules[$indexes[0]]['rules'])) {
            return $rules[$indexes[0]]['rules'];
        }
        
        if (count($indexes) > 1) {
            $currentRules = ['rules' => $rules];
            foreach ($indexes as $index) {
                if (isset($currentRules['rules'][$index])) {
                    $currentRules = $currentRules['rules'][$index];
                }
            }
            return $currentRules['rules'];
        }

        return [
            'type' => 'string',
        ];
    }

    protected function transform(mixed $value): mixed
    {
        $validValue = (array) $value;

        return $validValue;
    }

    public function validate(mixed $value): bool
    {
        return $this->_validate($value);
    }

    protected function _validate(mixed $value): bool
    {
        $value = $this->transform($value);

        $requiredResult = $this->validateRequired($value);
        if (null !== $requiredResult) {
            return $requiredResult;
        }

        if (array_is_list($value)) {
            $sequentialArrayResult = $this->validateSequentialArray($value);
            if (null !== $sequentialArrayResult) {
                return $sequentialArrayResult;
            }
        } else {
            $associativeArrayResult = $this->validateAssociativeArray($value);
            if (null !== $associativeArrayResult) {
                return $associativeArrayResult;
            }
        }

        return true;
    }

    public function validateSequentialArray(array $data): ?bool
    {
        $result = null;

        foreach ($data as $key => $value) {
            $validation = $this->validationTypeFactory->create(
                $this->getProperty() === '' ? $key : $this->getProperty() . '.' . $key,
                $this->getConfiguration(),
                $this->getRules()
            );
            if ($validation instanceof AbstractValidation) {
                $validationResult = $validation->validate($value);
                if (false === $validationResult) {
                    $result = false;
                }
            }
        }

        return $result;
    }

    public function validateAssociativeArray(array $data): ?bool
    {
        $result = null;

        foreach ($data as $key => $value) {
            $singleResult = $this->validateSingleProperty($key, $value);
            if ($singleResult === false) {
                $result = false;
            }
        }

        if (!$this->configuration->isRestrictMode()) {
            $remaining = array_diff(array_keys($this->getRules()), array_keys($data));
            foreach ($remaining as $key) {
                $singleResult = $this->validateSingleProperty($key, '');
                if ($singleResult === false) {
                    $result = false;
                }
            }
        }

        return $result;
    }

    protected function validateSingleProperty(string $key, mixed $value): ?bool
    {
        $result = null;

        if (isset($this->getRules()[$key])) {
            $validation = $this->validationTypeFactory->create(
                $this->getProperty() === '' ? $key : $this->getProperty() . '.' . $key,
                $this->getConfiguration(),
                $this->getRules()[$key]
            );
            if ($validation instanceof AbstractValidation) {
                $validationResult = $validation->validate($value);
                if (false === $validationResult) {
                    $result = false;
                }
            } elseif (!$this->configuration->isRestrictMode()) {
                $this->validDataBag->setData($key, $value);
            }
        } elseif (!$this->configuration->isRestrictMode()) {
            $this->validDataBag->setData($key, $value);
        }

        return $result;
    }
}
