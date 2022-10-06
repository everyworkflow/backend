<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\PageBuilderBundle\Component\PageHeader;

use EveryWorkflow\PageBuilderBundle\Component\ComponentInterface;
use EveryWorkflow\PageBuilderBundle\Component\LinkComponentFactory;

class MainMenuComponent implements ComponentInterface
{
    /**
     * @var LinkComponentFactory
     */
    protected LinkComponentFactory $linkComponentFactory;

    public function __construct(LinkComponentFactory $linkComponentFactory)
    {
        $this->linkComponentFactory = $linkComponentFactory;
    }

    public function getData(): ?array
    {
        return $this->generate();
    }

    protected function generate(): array
    {
        $data = [
            'items' => [],
        ];
        $data['items'][] = $this->linkComponentFactory->create()->setLabel('Home')->setUrl('/')->getData();
        $data['items'][] = $this->linkComponentFactory->create()->setLabel('About')->setUrl('/about')->getData();
        $data['items'][] = $this->linkComponentFactory->create()->setLabel('Contact')->setUrl('/contact')->getData();
        $data['items'][] = $this->linkComponentFactory->create()->setLabel('Tests')->setUrl('/test')->getData();
        return $data;
    }
}
