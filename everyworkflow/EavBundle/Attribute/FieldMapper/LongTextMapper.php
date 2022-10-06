<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Attribute\FieldMapper;

use EveryWorkflow\DataFormBundle\Field\BaseFieldInterface;
use EveryWorkflow\EavBundle\Attribute\BaseAttributeInterface;
use EveryWorkflow\EavBundle\Attribute\BaseFieldMapper;

class LongTextMapper extends BaseFieldMapper implements LongTextMapperInterface
{
    protected string $fieldType = 'textarea_field';

    public function map(BaseAttributeInterface $attribute): BaseFieldInterface
    {
        $data = $attribute->toArray();

        if (!isset($data['field_type'])) {
            $data['field_type'] = $this->fieldType;
        }

        return $this->formFieldFactory->create($data)
            ->setName($attribute->getCode())
            ->setLabel($attribute->getName());
    }
}
