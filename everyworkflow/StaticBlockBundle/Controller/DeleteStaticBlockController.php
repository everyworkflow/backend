<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\StaticBlockBundle\Controller;

use EveryWorkflow\CoreBundle\Annotation\EwRoute;
use EveryWorkflow\StaticBlockBundle\Repository\StaticBlockRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class DeleteStaticBlockController extends AbstractController
{
    protected StaticBlockRepositoryInterface $staticBlockRepository;

    public function __construct(StaticBlockRepositoryInterface $staticBlockRepository)
    {
        $this->staticBlockRepository = $staticBlockRepository;
    }

    #[EwRoute(
        path: "cms/static-block/{uuid}",
        name: 'cms.static_block.delete',
        methods: 'DELETE',
        permissions: 'cms.static_block.delete',
        swagger: [
            'parameters' => [
                [
                    'name' => 'uuid',
                    'in' => 'path',
                ]
            ]
        ]
    )]
    public function __invoke(string $uuid): JsonResponse
    {
        try {
            $this->staticBlockRepository->deleteOneByFilter(['_id' => new \MongoDB\BSON\ObjectId($uuid)]);
            return new JsonResponse(['detail' => 'ID: ' . $uuid . ' deleted successfully.']);
        } catch (\Exception $e) {
            return new JsonResponse(['detail' => $e->getMessage()], 500);
        }
    }
}
