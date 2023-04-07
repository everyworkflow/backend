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

class GetOrderController extends AbstractController
{
    public function __construct(
        protected SalesOrderRepositoryInterface $salesOrderRepository
    ) {
    }

    #[EwRoute(
        path: 'sales/order/{uuid}',
        name: 'sales.order.view',
        methods: 'GET',
        permissions: 'sales.order.view',
        swagger: [
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
            $item = $this->salesOrderRepository->findById($uuid);
            if ($item) {
                $data['item'] = $item->toArray();
            }
        }

        if ('data-form' === $request->get('for')) {
            $data['data_form'] = $this->salesOrderRepository->getForm()->toArray();
        }

        return new JsonResponse($data);
    }
}
