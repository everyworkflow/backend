<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CoreBundle\Validation\Type;

use EveryWorkflow\CoreBundle\Model\DataObject;
use EveryWorkflow\CoreBundle\Validation\ConfigurationInterface;
use EveryWorkflow\CoreBundle\Validation\ErrorBagInterface;
use EveryWorkflow\CoreBundle\Validation\ValidDataBagInterface;
use Symfony\Contracts\Service\Attribute\Required;

abstract class AbstractValidation extends DataObject
{
    public const KEY_PROPERTY = 'property';
    public const KEY_PROPERTY_NAME = 'property_name';
    public const KEY_REQUIRED = 'required';
    public const KEY_DEFAULT = 'default';

    protected ConfigurationInterface $configuration;
    protected ErrorBagInterface $errorBag;
    protected ValidDataBagInterface $validDataBag;

    #[Required]
    public function setConfiguration(ConfigurationInterface $configuration): self
    {
        $this->configuration = $configuration;
        $this->errorBag = $configuration->getErrorBag();
        $this->validDataBag = $configuration->getValidDataBag();

        return $this;
    }

    public function getConfiguration(): ConfigurationInterface
    {
        return $this->configuration;
    }

    public function setProperty(string $property): self
    {
        $this->setData(self::KEY_PROPERTY, $property);

        return $this;
    }

    public function getProperty(): ?string
    {
        return $this->getData(self::KEY_PROPERTY);
    }

    public function setPropertyName(string $propertyName): self
    {
        $this->setData(self::KEY_PROPERTY_NAME, $propertyName);

        return $this;
    }

    public function getPropertyName(): ?string
    {
        $propertyName = $this->getData(self::KEY_PROPERTY_NAME);
        if (null === $propertyName) {
            $propertyName = 'The ' . $this->getProperty();
        }

        return $propertyName;
    }

    public function setRequired(bool $required): self
    {
        $this->setData(self::KEY_REQUIRED, $required);

        return $this;
    }

    public function isRequired(): bool
    {
        return $this->getData(self::KEY_REQUIRED) ?? false;
    }

    public function setDefault(mixed $default): self
    {
        $this->setData(self::KEY_DEFAULT, $default);

        return $this;
    }

    public function getDefault(): mixed
    {
        return $this->getData(self::KEY_DEFAULT);
    }

    protected function setDefaultIfNot(): self
    {
        $defaultValue = $this->transform($this->getDefault());
        $this->setValidData($defaultValue);

        return $this;
    }

    protected function validateRequired($value): ?bool
    {
        if ($this->isRequired() && empty($value)) {
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

    public function setValidData(mixed $value): self
    {
        $indexes = explode('.', $this->getProperty());
        if (count($indexes) === 1) {
            $this->validDataBag->setData($this->getProperty(), $value);
            return $this;
        }

        if (count($indexes) > 1) {
            $firstIndex = array_shift($indexes);
            $currentValue = $this->validDataBag->getData($firstIndex);
            if (!is_array($currentValue)) {
                $currentValue = [];
            }
            $currentValuePtr = &$currentValue;
            foreach ($indexes as $index) {
                if (!isset($currentValuePtr[$index])) {
                    $currentValuePtr[$index] = [];
                }
                $currentValuePtr = &$currentValuePtr[$index];
            }
            $currentValuePtr = $value;
            $this->validDataBag->setData($firstIndex, $currentValue);
        }

        return $this;
    }

    abstract protected function transform(mixed $value): mixed;

    public function validate(mixed $value): bool
    {
        if ($this->getProperty() === null) {
            $this->errorBag->addError('_error', 'Property is not set.');
            return false;
        }

        return $this->_validate($value);
    }

    abstract protected function _validate(mixed $value): bool;
}
