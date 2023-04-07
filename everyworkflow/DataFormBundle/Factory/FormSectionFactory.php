<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataFormBundle\Factory;

use EveryWorkflow\DataFormBundle\Model\DataFormConfigProviderInterface;
use EveryWorkflow\DataFormBundle\Section\BaseSectionInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class FormSectionFactory implements FormSectionFactoryInterface
{
    public function __construct(
        protected ContainerInterface $container,
        protected DataFormConfigProviderInterface $dataFormConfigProvider
    ) {
    }

    public function createFromClassName(string $className, array $data = []): ?BaseSectionInterface
    {
        if ($this->container->has($className)) {
            $section = $this->container->get($className);
            if ($section instanceof BaseSectionInterface) {
                if (isset($data['fields'])) {
                    $fields = $data['fields'];
                    $section->setFields($fields);
                    unset($data['fields']);
                }

                return $section->resetData($data);
            }
        }

        return null;
    }

    public function createFromType(string $sectionType, array $data = []): ?BaseSectionInterface
    {
        $sections = $this->dataFormConfigProvider->get('sections');
        if (isset($sections[$sectionType])) {
            return $this->createFromClassName($sections[$sectionType], $data);
        }

        return $this->create($data);
    }

    public function create(array $data = []): ?BaseSectionInterface
    {
        $sections = $this->dataFormConfigProvider->get('sections');
        if (isset($data['section_type'], $sections[$data['section_type']])) {
            return $this->createFromClassName($sections[$data['section_type']], $data);
        }
        $sectionType = $this->dataFormConfigProvider->get('default.section');

        return $this->createFromClassName($sections[$sectionType], $data);
    }
}
