<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataFormBundle\Factory;

use EveryWorkflow\DataFormBundle\Model\Form;
use EveryWorkflow\DataFormBundle\Model\FormInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class FormFactory implements FormFactoryInterface
{
    protected ContainerInterface $container;

    public function __construct(
        ContainerInterface $container
    ) {
        $this->container = $container;
    }

    public function create(array $data = []): ?FormInterface
    {
        return $this->createByClassName(Form::class, $data);
    }

    public function createByClassName($className, array $data = []): ?FormInterface
    {
        if ($this->container->has($className)) {
            $form = $this->container->get($className);
            if ($form instanceof FormInterface) {
                return $form->resetData($data);
            }
        }

        return null;
    }
}
