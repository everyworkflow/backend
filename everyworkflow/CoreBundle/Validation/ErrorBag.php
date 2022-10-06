<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CoreBundle\Validation;

use EveryWorkflow\CoreBundle\Model\DataObject;

class ErrorBag extends DataObject implements ErrorBagInterface
{
    public function getAllErrors(): array
    {
        return $this->toArray();
    }

    /**
     * @return string[]
     */
    public function getErrors(string $property): array
    {
        return $this->getData($property) ?? [];
    }

    /**
     * @param string[] $messages
     */
    public function setErrors(string $property, array $messages): self
    {
        $this->setData($property, $messages);

        return $this;
    }

    public function addError(string $property, string $message): self
    {
        $indexes = explode('.', $property);
        if (count($indexes) === 1) {
            $errors = $this->getErrors($property);
            $errors['errors'][] = $message;
            $this->setErrors($property, $errors);
            return $this;
        }

        if (count($indexes) > 1) {
            $firstIndex = array_shift($indexes);
            $errors = $this->getErrors($firstIndex);
            $errorsPtr = &$errors;

            foreach ($indexes as $index) {
                if (!isset($errorsPtr[$index])) {
                    $errorsPtr[$index] = [];
                }
                $errorsPtr = &$errorsPtr[$index];
            }
            $errorsPtr['errors'][] = $message;
            $this->setErrors($firstIndex, $errors);

            return $this;
        }

        return $this;
    }

    public function clear(): self
    {
        $this->data = [];

        return $this;
    }
}
