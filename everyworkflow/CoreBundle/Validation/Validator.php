<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CoreBundle\Validation;

use Doctrine\Inflector\InflectorFactory;
use EveryWorkflow\CoreBundle\Factory\ValidationTypeFactoryInterface;
use EveryWorkflow\CoreBundle\Support\ArrayableInterface;
use ReflectionClass;

class Validator implements ValidatorInterface
{
    protected ValidationTypeFactoryInterface $validationTypeFactory;
    protected ConfigurationInterface $configuration;

    public function __construct(
        ValidationTypeFactoryInterface $validationTypeFactory,
        ConfigurationInterface $configuration
    ) {
        $this->validationTypeFactory = $validationTypeFactory;
        $this->configuration = $configuration;
    }

    public function isRestrictMode(): bool
    {
        return $this->configuration->isRestrictMode();
    }

    public function setRestrictMode(bool $restrictMode): self
    {
        $this->configuration->setRestrictMode($restrictMode);

        return $this;
    }

    public function getValidData(): array
    {
        return $this->configuration->getValidDataBag()->toArray();
    }

    public function getAllErrors(): array
    {
        return $this->configuration->getErrorBag()->toArray();
    }

    public function hasErrors(): bool
    {
        if (count($this->getAllErrors()) > 0) {
            return true;
        }

        return false;
    }

    public function getRules(): array
    {
        return $this->configuration->getRules();
    }

    public function setRules(array $rules): self
    {
        $this->configuration->setRules($rules);

        return $this;
    }

    public function validate(mixed $data): bool
    {
        if (is_array($data)) {
            return $this->validateArray($data);
        }

        if ($data instanceof ArrayableInterface) {
            return $this->validateObject($data);
        }

        return false;
    }

    public function validateArray(array $data): bool
    {
        $arrayValidation = $this->validationTypeFactory->createFromType('array', '', $this->configuration);
        if ($arrayValidation) {
            return $arrayValidation->validate($data);
        }

        return false;
    }

    public function validateObject(ArrayableInterface $object): bool
    {
        $this->resolveObjectRules($object);
        return $this->validateArray($object->toArray());
    }

    protected function resolveObjectRules(ArrayableInterface $object): void
    {
        $rules = $this->getRules();

        $reflectionClass = new ReflectionClass(get_class($object));
        foreach ($reflectionClass->getMethods() as $method) {
            $dataKey = $method->getName();
            $propertyName = InflectorFactory::create()->build()->tableize($dataKey);
            $propertyNameArr = explode('_', $propertyName);
            if (count($propertyNameArr) && ($propertyNameArr[0] === 'set' || $propertyNameArr[0] === 'get')) {
                array_shift($propertyNameArr);
            }
            $propertyName = implode('_', $propertyNameArr);
            foreach ($method->getAttributes() as $attribute) {
                $rules[$propertyName] = [
                    'type_class_name' => $attribute->getName(),
                ];
                foreach ($attribute->getArguments() as $key => $val) {
                    $argKey = InflectorFactory::create()->build()->tableize($key);
                    $rules[$propertyName][$argKey] = $val;
                }
            }
        }

        $this->setRules($rules);
    }
}
