<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\SalesOrderBundle\Controller;

use EveryWorkflow\CoreBundle\Annotation\EwRoute;
use EveryWorkflow\SalesOrderBundle\Repository\SalesOrderRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class BulkActionOrderController extends AbstractController
{
    public function __construct(
        protected SalesOrderRepositoryInterface $salesOrderRepository
    ) {
    }

    #[EwRoute(
        path: 'sales/order/bulk-action/{action}',
        name: 'sales.order.bulk_action',
        methods: 'POST',
        permissions: 'sales.order.save',
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
                $result = $this->salesOrderRepository->bulkUpdateByIds($submitData['rows'], ['status' => 'enable']);

                return new JsonResponse([
                    'detail' => 'Total '.$result->getModifiedCount().' selected data updated.',
                ]);

            case 'disable':
                $result = $this->salesOrderRepository->bulkUpdateByIds($submitData['rows'], ['status' => 'disable']);

                return new JsonResponse([
                    'detail' => 'Total '.$result->getModifiedCount().' selected data updated.',
                ]);
        }

        return new JsonResponse(['detail' => 'Action invalid.'], 400);
    }
}
