<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataFormBundle\Field;

use EveryWorkflow\CoreBundle\Support\ArrayableInterface;
use EveryWorkflow\DataFormBundle\Field\Select\OptionInterface;

class RadioField extends BaseField implements RadioFieldInterface
{
    protected string $fieldType = 'radio_field';

    /**
     * @return OptionInterface[]
     */
    public function getOptions(): array
    {
        return $this->dataObject->getData(self::KEY_OPTIONS);
    }

    /**
     * @param OptionInterface[] $options
     * @return self
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
