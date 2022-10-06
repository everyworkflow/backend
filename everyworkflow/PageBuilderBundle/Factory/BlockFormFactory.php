<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\PageBuilderBundle\Factory;

use EveryWorkflow\DataFormBundle\Factory\FormFactoryInterface;
use EveryWorkflow\DataFormBundle\Model\FormInterface;
use EveryWorkflow\PageBuilderBundle\Model\PageBuilderConfigProviderInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class BlockFormFactory implements BlockFormFactoryInterface
{
    protected ContainerInterface $container;
    protected PageBuilderConfigProviderInterface $pageBuilderConfigProvider;
    protected FormFactoryInterface $formFactory;

    public function __construct(
        ContainerInterface $container,
        PageBuilderConfigProviderInterface $pageBuilderConfigProvider,
        FormFactoryInterface $formFactory
    ) {
        $this->container = $container;
        $this->pageBuilderConfigProvider = $pageBuilderConfigProvider;
        $this->formFactory = $formFactory;
    }

    public function createFormForBlockType(string $blockType): FormInterface
    {
        $blockForms = $this->pageBuilderConfigProvider->get('block_forms');
        if (isset($blockForms[$blockType]) && $this->container->has($blockForms[$blockType])) {
            $blockForm = $this->container->get($blockForms[$blockType]);
            if ($blockForm instanceof FormInterface) {
                return $blockForm;
            }
        }
        return $this->formFactory->create();
    }
}
