<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\PageBuilderBundle\Component;

use EveryWorkflow\PageBuilderBundle\Component\PageHeader\MainMenuComponent;
use Symfony\Component\Asset\Package;

class PageHeaderComponent implements ComponentInterface
{
    /**
     * @var Package
     */
    protected Package $package;
    /**
     * @var MainMenuComponent
     */
    protected MainMenuComponent $mainMenuComponent;
    /**
     * @var ImageComponentFactory
     */
    protected ImageComponentFactory $imageComponentFactory;

    public function __construct(
        Package $package,
        MainMenuComponent $mainMenuComponent,
        ImageComponentFactory $imageComponentFactory
    ) {
        $this->package = $package;
        $this->mainMenuComponent = $mainMenuComponent;
        $this->imageComponentFactory = $imageComponentFactory;
    }

    public function getData(): ?array
    {
        return [
            'header_top' => [
                'company_email' => 'info@everyworkflow.com',
            ],
            'logo' => $this->imageComponentFactory->create()
                ->setUrl($this->package->getUrl('/media/logo.svg'))
                ->setAlt('EveryWorkflow')->getData(),
            'main_menu' => $this->mainMenuComponent->getData(),
            'customer' => null,
        ];
    }
}
