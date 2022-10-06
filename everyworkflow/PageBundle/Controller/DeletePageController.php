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

class DeletePageController extends AbstractController
{
    protected PageRepositoryInterface $pageRepository;

    public function __construct(PageRepositoryInterface $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    #[EwRoute(
        path: "cms/page/{uuid}",
        name: 'cms.page.delete',
        methods: 'DELETE',
        permissions: 'cms.page.delete',
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
            $this->pageRepository->deleteOneByFilter(['_id' => new \MongoDB\BSON\ObjectId($uuid)]);
            return new JsonResponse(['detail' => 'ID: ' . $uuid . ' deleted successfully.']);
        } catch (\Exception $e) {
            return new JsonResponse(['detail' => $e->getMessage()], 500);
        }
    }
}
