<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Attribute\FieldMapper;

use EveryWorkflow\DataFormBundle\Field\BaseFieldInterface;
use EveryWorkflow\EavBundle\Attribute\BaseAttributeInterface;
use EveryWorkflow\EavBundle\Attribute\BaseFieldMapper;
use EveryWorkflow\EavBundle\Attribute\Type\SelectAttributeInterface;

class SelectMapper extends BaseFieldMapper implements SelectMapperInterface
{
    protected string $fieldType = 'select_field';

    public function map(BaseAttributeInterface|SelectAttributeInterface $attribute): BaseFieldInterface
    {
        $data = $attribute->toArray();
        if (isset($data['options']) && is_array($data['options'])) {
            $options = [];
            foreach ($data['options'] as $item) {
                if (isset($item['key'], $item['value'])) {
                    $options[] = $item;
                } else if (isset($item['code'], $item['label'])) {
                    $options[] = [
                        'key' => $item['code'],
                        'value' => $item['label'],
                    ];
                }
            }
            $data['options'] = $options;
        }

        $data['field_type'] = $this->fieldType;

        return $this->formFieldFactory->create($data)
            ->setName($attribute->getCode())
            ->setLabel($attribute->getName());
    }
}
