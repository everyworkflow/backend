<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataFormBundle\Factory;

use EveryWorkflow\DataFormBundle\Field\BaseFieldInterface;
use EveryWorkflow\DataFormBundle\Model\DataFormConfigProviderInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class FormFieldFactory implements FormFieldFactoryInterface
{
    protected ContainerInterface $container;
    protected DataFormConfigProviderInterface $dataFormConfigProvider;

    public function __construct(
        ContainerInterface $container,
        DataFormConfigProviderInterface $dataFormConfigProvider
    ) {
        $this->container = $container;
        $this->dataFormConfigProvider = $dataFormConfigProvider;
    }

    public function createFromClassName(string $className, array $data = []): ?BaseFieldInterface
    {
        if ($this->container->has($className)) {
            $field = $this->container->get($className);
            if ($field instanceof BaseFieldInterface) {
                return $field->resetData($data);
            }
        }
        return null;
    }

    public function createFromType(string $fieldType, array $data = []): ?BaseFieldInterface
    {
        $fields = $this->dataFormConfigProvider->get('fields');
        if (isset($fields[$fieldType])) {
            return $this->createFromClassName($fields[$fieldType], $data);
        }
        return $this->create($data);
    }

    public function create(array $data = []): ?BaseFieldInterface
    {
        $fields = $this->dataFormConfigProvider->get('fields');
        if (isset($data['field_type'], $fields[$data['field_type']])) {
            return $this->createFromClassName($fields[$data['field_type']], $data);
        }
        $fieldType = $this->dataFormConfigProvider->get('default.field');
        return $this->createFromClassName($fields[$fieldType], $data);
    }
}
