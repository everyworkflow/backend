<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\PageBuilderBundle\Factory;

use EveryWorkflow\CoreBundle\Model\DataObjectFactoryInterface;
use EveryWorkflow\PageBuilderBundle\Block\AbstractBlockInterface;
use EveryWorkflow\PageBuilderBundle\Model\PageBuilderConfigProviderInterface;

class BlockFactory implements BlockFactoryInterface
{
    public function __construct(
        protected DataObjectFactoryInterface $dataObjectFactory,
        protected PageBuilderConfigProviderInterface $pageBuilderConfigProvider
    ) {
    }

    public function create(string $className, array $data): AbstractBlockInterface
    {
        return new $className($this->dataObjectFactory->create($data));
    }

    public function createBlockFromType(string $blockType, array $data): AbstractBlockInterface
    {
        $blocks = $this->pageBuilderConfigProvider->get('blocks');
        if (isset($blocks[$blockType])) {
            $dataObject = $this->dataObjectFactory->create($data);

            return new $blocks[$blockType]($dataObject);
        }

        return $this->createBlock($data);
    }

    public function createBlock(array $data): AbstractBlockInterface
    {
        $blocks = $this->pageBuilderConfigProvider->get('blocks');
        if (isset($data['block_type'], $blocks[$data['block_type']])) {
            return new $blocks[$data['block_type']]($this->dataObjectFactory->create($data));
        }
        $blockType = $this->pageBuilderConfigProvider->get('default.block');

        return new $blocks[$blockType]($this->dataObjectFactory->create($data));
    }
}
