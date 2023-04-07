<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\MediaManagerBundle\Attribute\FieldMapper;

use EveryWorkflow\DataFormBundle\Field\BaseFieldInterface;
use EveryWorkflow\EavBundle\Attribute\BaseAttributeInterface;
use EveryWorkflow\EavBundle\Attribute\BaseFieldMapper;

class MediaMapper extends BaseFieldMapper implements MediaMapperInterface
{
    protected string $fieldType = 'media_image_selector_field';

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
