<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CoreBundle\Factory;

use EveryWorkflow\CoreBundle\Model\CoreConfigProviderInterface;
use EveryWorkflow\CoreBundle\Model\DataObjectFactoryInterface;
use EveryWorkflow\CoreBundle\Validation\ConfigurationInterface;
use EveryWorkflow\CoreBundle\Validation\Type\AbstractValidation;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ValidationTypeFactory implements ValidationTypeFactoryInterface
{
    protected ContainerInterface $container;
    protected CoreConfigProviderInterface $coreConfigProvider;
    protected DataObjectFactoryInterface $dataObjectFactory;

    public function __construct(
        ContainerInterface $container,
        CoreConfigProviderInterface $coreConfigProvider,
        DataObjectFactoryInterface $dataObjectFactory
    ) {
        $this->container = $container;
        $this->coreConfigProvider = $coreConfigProvider;
        $this->dataObjectFactory = $dataObjectFactory;
    }

    public function create(
        string $property,
        ?ConfigurationInterface $configuration = null,
        array $data = []
    ): ?AbstractValidation {
        if (isset($data['type']) && !empty($data['type'])) {
            return $this->createFromType($data['type'], $property, $configuration, $data);
        }
        if (isset($data['type_class_name']) && !empty($data['type_class_name'])) {
            return $this->createFromClassName($data['type_class_name'], $property, $configuration, $data);
        }

        return null;
    }

    public function createFromType(
        string $type,
        string $property,
        ?ConfigurationInterface $configuration = null,
        array $data = []
    ): ?AbstractValidation {
        $validationClassName = $this->coreConfigProvider->get('validation_types.' . $type);
        if ($validationClassName) {
            return $this->createFromClassName($validationClassName, $property, $configuration, $data);
        }

        return null;
    }

    public function createFromClassName(
        string $className,
        string $property,
        ?ConfigurationInterface $configuration = null,
        array $data = [],
    ): ?AbstractValidation {
        if ($this->container->has($className)) {
            $validation = $this->container->get($className);
            if ($validation instanceof AbstractValidation) {
                $validation->resetData($data);
                $validation->setProperty($property);
                if ($configuration !== null) {
                    $validation->setConfiguration($configuration);
                }

                return $validation;
            }
        }

        return null;
    }
}
