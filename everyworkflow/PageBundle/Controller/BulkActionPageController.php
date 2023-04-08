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

class BulkActionPageController extends AbstractController
{
    public function __construct(
        protected PageRepositoryInterface $pageRepository
    ) {
    }

    #[EwRoute(
        path: 'cms/page/bulk-action/{action}',
        name: 'cms.page.bulk_action',
        methods: 'POST',
        permissions: 'cms.page.save',
        swagger: [
            'parameters' => [
                [
                    'name' => 'action',
                    'in' => 'path',
                ],
            ],
            'requestBody' => [
                'content' => [
                    'application/json' => [
                        'schema' => [
                            'properties' => [
                                'rows' => [
                                    'type' => 'array',
                                    'items' => [
                                        'type' => 'string',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]
    )]
    public function __invoke(Request $request, $action): JsonResponse
    {
        $submitData = $request->toArray();

        if (!isset($submitData['rows']) || !is_array($submitData['rows']) || 0 === count($submitData['rows'])) {
            return new JsonResponse(['detail' => 'Action invalid.'], 400);
        }

        switch ($action) {
            case 'enable':
                $result = $this->pageRepository->bulkUpdateByIds($submitData['rows'], ['status' => 'enable']);

                return new JsonResponse([
                    'detail' => 'Total ' . $result->getModifiedCount() . ' selected data updated.',
                ]);

            case 'disable':
                $result = $this->pageRepository->bulkUpdateByIds($submitData['rows'], ['status' => 'disable']);

                return new JsonResponse([
                    'detail' => 'Total ' . $result->getModifiedCount() . ' selected data updated.',
                ]);
        }

        return new JsonResponse(['detail' => 'Action invalid.'], 400);
    }
}
