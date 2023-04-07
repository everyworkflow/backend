<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\PageBuilderBundle\Controller;

use EveryWorkflow\CoreBundle\Annotation\EwRoute;
use EveryWorkflow\PageBuilderBundle\Component\PageFooterComponent;
use EveryWorkflow\PageBuilderBundle\Component\PageHeaderComponent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class LayoutController extends AbstractController
{
    #[EwRoute(
        path: 'page-builder/layout',
        name: 'page_builder.layout',
        methods: 'GET',
        swagger: true
    )]
    public function __invoke(
        PageHeaderComponent $pageHeaderComponent,
        PageFooterComponent $pageFooterComponent
    ): JsonResponse {
        $data = [
            'page_header' => $pageHeaderComponent->getData(),
            'page_footer' => $pageFooterComponent->getData(),
        ];

        return new JsonResponse($data);
    }
}
