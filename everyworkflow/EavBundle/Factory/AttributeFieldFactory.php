<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Factory;

use EveryWorkflow\DataFormBundle\Factory\FormFieldFactory;
use EveryWorkflow\DataFormBundle\Field\BaseFieldInterface;
use EveryWorkflow\DataFormBundle\Model\DataFormConfigProviderInterface;
use EveryWorkflow\EavBundle\Attribute\BaseAttributeInterface;
use EveryWorkflow\EavBundle\Attribute\BaseFieldMapper;
use EveryWorkflow\EavBundle\Attribute\BaseFieldMapperInterface;
use EveryWorkflow\EavBundle\Model\EavConfigProviderInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AttributeFieldFactory extends FormFieldFactory implements AttributeFieldFactoryInterface
{
    public function __construct(
        ContainerInterface $container,
        DataFormConfigProviderInterface $dataFormConfigProvider,
        protected EavConfigProviderInterface $eavConfigProvider
    ) {
        parent::__construct($container, $dataFormConfigProvider);
    }

    public function createFromAttribute(BaseAttributeInterface $attribute): BaseFieldInterface
    {
        $typeToFieldMappers = $this->eavConfigProvider->get('attribute_type_to_form_field_mapper');

        if ($attribute->getType() && isset($typeToFieldMappers[$attribute->getType()])) {
            $className = $typeToFieldMappers[$attribute->getType() ?? ''];
            if ($this->container->has($className)) {
                $fieldMapper = $this->container->get($className);
                if ($fieldMapper instanceof BaseFieldMapperInterface) {
                    return $fieldMapper->map($attribute);
                }
            }
        }

        return (new BaseFieldMapper($this))->map($attribute);
    }
}
