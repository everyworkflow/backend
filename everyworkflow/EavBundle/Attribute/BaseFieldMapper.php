<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Attribute;

use EveryWorkflow\DataFormBundle\Factory\FormFieldFactoryInterface;
use EveryWorkflow\DataFormBundle\Field\BaseFieldInterface;

class BaseFieldMapper implements BaseFieldMapperInterface
{
    protected string $fieldType = 'text_field';

    protected FormFieldFactoryInterface $formFieldFactory;

    public function __construct(FormFieldFactoryInterface $formFieldFactory)
    {
        $this->formFieldFactory = $formFieldFactory;
    }

    public function map(BaseAttributeInterface $attribute): BaseFieldInterface
    {
        $data = $attribute->toArray();
        $data['field_type'] = $this->fieldType;

        return $this->formFieldFactory->create($data)
            ->setName($attribute->getCode())
            ->setLabel($attribute->getName());
    }
}
