<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Factory;

use Carbon\Carbon;
use EveryWorkflow\CoreBundle\Helper\Trait\GenerateSetMethodNameTrait;
use EveryWorkflow\CoreBundle\Model\DataObjectFactoryInterface;
use EveryWorkflow\EavBundle\Attribute\BaseAttributeInterface;
use EveryWorkflow\EavBundle\Model\EavConfigProviderInterface;
use EveryWorkflow\MongoBundle\Document\HelperTrait\CreatedUpdatedHelperTraitInterface;
use EveryWorkflow\MongoBundle\Factory\DocumentFactory;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AttributeFactory extends DocumentFactory implements AttributeFactoryInterface
{
    use GenerateSetMethodNameTrait;

    protected ContainerInterface $container;
    protected EavConfigProviderInterface $eavConfigProvider;

    public function __construct(
        DataObjectFactoryInterface $dataObjectFactory,
        ContainerInterface         $container,
        EavConfigProviderInterface $eavConfigProvider
    ) {
        parent::__construct($dataObjectFactory);
        $this->container = $container;
        $this->eavConfigProvider = $eavConfigProvider;
    }

    protected function fillFieldWithData(mixed $field, array $data): ?BaseAttributeInterface
    {
        if ($field instanceof BaseAttributeInterface) {
            $field->resetData($data);
            
            return $field;
        }

        return null;
    }

    public function createAttributeFromType(string $type, array $data = []): ?BaseAttributeInterface
    {
        $attributeTypes = $this->eavConfigProvider->get('attribute_types');

        if (isset($attributeTypes[$type]) && $this->container->has($attributeTypes[$type])) {
            $field = $this->container->get($attributeTypes[$type]);

            return $this->fillFieldWithData($field, $data);
        }

        $baseEntityClassname = $this->eavConfigProvider->get('default.entity_class');
        if ($this->container->has($baseEntityClassname)) {
            $field = $this->container->get($baseEntityClassname);

            return $this->fillFieldWithData($field, $data);
        }

        return null;
    }

    public function createAttribute(array $data = []): ?BaseAttributeInterface
    {
        if (!isset($data['type'])) {
            $data['type'] = $this->eavConfigProvider->get('default.attribute_type');
        }

        return $this->createAttributeFromType($data['type'], $data);
    }
}
