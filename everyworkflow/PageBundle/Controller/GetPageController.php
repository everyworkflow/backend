<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\PageBundle\Controller;

use EveryWorkflow\CoreBundle\Annotation\EwRoute;
use EveryWorkflow\PageBundle\Repository\PageRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class GetPageController extends AbstractController
{
    public function __construct(
        protected PageRepositoryInterface $pageRepository
    ) {
    }

    #[EwRoute(
        path: 'cms/page/{uuid}',
        name: 'cms.page.view',
        methods: 'GET',
        permissions: 'cms.page.view',
        swagger: [
            'tags' => ['cms_page'],
            'parameters' => [
                [
                    'name' => 'uuid',
                    'in' => 'path',
                    'default' => 'create',
                ],
            ],
        ]
    )]
    public function __invoke(Request $request, string $uuid = 'create'): JsonResponse
    {
        $data = [];

        if ('create' !== $uuid) {
            $item = $this->pageRepository->findById($uuid);
            if ($item) {
                $data['item'] = $item->toArray();
            }
        }

        if ('data-form' === $request->get('for')) {
            $data['data_form'] = $this->pageRepository->getForm()->toArray();
        }

        return new JsonResponse($data);
    }
}
