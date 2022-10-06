<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Attribute\Type;

use EveryWorkflow\CoreBundle\Model\DataObjectInterface;
use EveryWorkflow\CoreBundle\Support\ArrayableInterface;
use EveryWorkflow\EavBundle\Attribute\BaseAttribute;
use EveryWorkflow\EavBundle\Attribute\Type\Select\OptionInterface;

class SelectAttribute extends BaseAttribute implements SelectAttributeInterface
{
    protected string $attributeType = 'select_attribute';

    /**
     * @var OptionInterface[]
     */
    protected array $options = [];

    public function __construct(DataObjectInterface $dataObject)
    {
        parent::__construct($dataObject);
        $options = $dataObject->getData('options');
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    /**
     * @param OptionInterface[] | \MongoDB\Model\BSONArray $options
     */
    public function setOptions(array|\MongoDB\Model\BSONArray $options): self
    {
        if (is_array($options)) {
            $this->options = $options;
        } elseif ($options instanceof \MongoDB\Model\BSONArray) {
            foreach ($options as $option) {
                if ($option instanceof \MongoDB\Model\BSONDocument) {
                    $this->options[] = $option->getArrayCopy();
                } else if (is_array($option)) {
                    $this->options[] = $option;
                }
            }
        }

        return $this;
    }

    /**
     * @return OptionInterface[]
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    public function toArray(): array
    {
        $data = parent::toArray();
        foreach ($this->getOptions() as $option) {
            if ($option instanceof ArrayableInterface) {
                $data['options'][] = $option->toArray();
            } elseif (is_array($option)) {
                $data['options'][] = $option;
            }
        }
        return $data;
    }
}
