<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataFormBundle\Field;

use EveryWorkflow\CoreBundle\Support\ArrayableInterface;
use EveryWorkflow\DataFormBundle\Field\Select\OptionInterface;

class SelectField extends BaseField implements SelectFieldInterface
{
    protected string $fieldType = 'select_field';

    public function isSearchable(): bool
    {
        return $this->dataObject->getData(self::KEY_IS_SEARCHABLE) ?? false;
    }

    public function setIsSearchable(bool $isSearchable): self
    {
        $this->dataObject->setData(self::KEY_IS_SEARCHABLE, $isSearchable);

        return $this;
    }

    /**
     * @return OptionInterface[]
     */
    public function getOptions(): array
    {
        return $this->dataObject->getData(self::KEY_OPTIONS) ?? [];
    }

    /**
     * @param OptionInterface[] $options
     */
    public function setOptions(array $options): self
    {
        $this->dataObject->setData(self::KEY_OPTIONS, $options);

        return $this;
    }

    /**
     * Export data to array.
     */
    public function toArray(): array
    {
        $data = parent::toArray();
        $options = $this->getOptions();
        if (count($options)) {
            $optionData = [];
            foreach ($options as $option) {
                if ($option instanceof ArrayableInterface) {
                    $optionData[] = $option->toArray();
                } elseif (is_array($option)) {
                    $optionData[] = $option;
                }
            }
            $data[self::KEY_OPTIONS] = $optionData;
        }

        return $data;
    }
}
