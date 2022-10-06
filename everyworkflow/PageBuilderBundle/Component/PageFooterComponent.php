<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\PageBuilderBundle\Component;

use Symfony\Component\Asset\Package;

class PageFooterComponent implements ComponentInterface
{
    /**
     * @var LinkComponentFactory
     */
    protected LinkComponentFactory $linkComponentFactory;
    /**
     * @var Package
     */
    protected Package $package;
    /**
     * @var ImageComponentFactory
     */
    protected ImageComponentFactory $imageComponentFactory;

    public function __construct(
        LinkComponentFactory $linkComponentFactory,
        Package $package,
        ImageComponentFactory $imageComponentFactory
    ) {
        $this->linkComponentFactory = $linkComponentFactory;
        $this->package = $package;
        $this->imageComponentFactory = $imageComponentFactory;
    }

    public function getData(): ?array
    {
        $data = [];
        $data['footer_logo'] = $this->imageComponentFactory->create()
            ->setUrl($this->package->getUrl('/media/logo.svg'))
            ->setAlt('Every Workflow')
            ->getData();
        $data['footer_bottom_links'] = $this->getFooterBottomLinks();
        $data['footer_social_links'] = $this->getSocialLinks();
        $data['copyright'] = '© ' . date('Y') . ' EveryWorkflow. All rights reserved.';
        $data['tagline'] = 'Something wonderful';
        return $data;
    }

    protected function getSocialLinks(): array
    {
        $data = [];
        $data[] = $this->linkComponentFactory->create()->setLabel('Facebook')->setUrl('#')->getData();
        $data[] = $this->linkComponentFactory->create()->setLabel('Linkedin')->setUrl('#')->getData();
        $data[] = $this->linkComponentFactory->create()->setLabel('Twitter')->setUrl('#')->getData();
        return $data;
    }

    protected function getFooterBottomLinks(): array
    {
        $data = [];
        $data[] = $this->linkComponentFactory->create()->setLabel('Feedback')->setUrl('/feedback')->getData();
        $data[] = $this->linkComponentFactory->create()->setLabel('Affiliates')->setUrl('/affiliates')->getData();
        $data[] = $this->linkComponentFactory->create()->setLabel('Support')->setUrl('/support')->getData();
        $data[] = $this->linkComponentFactory->create()->setLabel('Privacy policy')->setUrl('/privacy-policy')->getData();
        $data[] = $this->linkComponentFactory->create()->setLabel('Terms of use')->setUrl('/terms-of-use')->getData();
        return $data;
    }
}
