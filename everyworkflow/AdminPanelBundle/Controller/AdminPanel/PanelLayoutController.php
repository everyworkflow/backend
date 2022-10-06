<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\AdminPanelBundle\Controller\AdminPanel;

use EveryWorkflow\AdminPanelBundle\Component\Admin\FooterComponentInterface;
use EveryWorkflow\AdminPanelBundle\Component\Admin\HeaderComponentInterface;
use EveryWorkflow\AdminPanelBundle\Component\Admin\SidebarComponentInterface;
use EveryWorkflow\CoreBundle\Annotation\EwRoute;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class PanelLayoutController extends AbstractController
{
    #[EwRoute(
        path: 'api/admin-panel/layout',
        name: 'admin_panel.layout',
        methods: 'GET',
        permissions: 'auth.admin',
        swagger: true
    )]
    public function __invoke(
        HeaderComponentInterface $headerComponent,
        SidebarComponentInterface $sidebarComponent,
        FooterComponentInterface $footerComponent
    ): JsonResponse {
        $data = [
            'panel_header' => $headerComponent->getData(),
            'panel_sidebar' => $sidebarComponent->getData(),
            'panel_footer' => $footerComponent->getData(),
        ];

        return new JsonResponse($data, JsonResponse::HTTP_OK);
    }
}
