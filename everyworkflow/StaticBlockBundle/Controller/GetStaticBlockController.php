<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\StaticBlockBundle\Controller;

use EveryWorkflow\CoreBundle\Annotation\EwRoute;
use EveryWorkflow\StaticBlockBundle\Form\StaticBlockFormInterface;
use EveryWorkflow\StaticBlockBundle\Repository\StaticBlockRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class GetStaticBlockController extends AbstractController
{
    protected StaticBlockFormInterface $staticBlockForm;
    protected StaticBlockRepositoryInterface $staticBlockRepository;

    public function __construct(
        StaticBlockFormInterface $staticBlockForm,
        StaticBlockRepositoryInterface $staticBlockRepository
    ) {
        $this->staticBlockForm = $staticBlockForm;
        $this->staticBlockRepository = $staticBlockRepository;
    }

    #[EwRoute(
        path: "cms/static-block/{uuid}",
        name: 'cms.static_block.view',
        methods: 'GET',
        permissions: 'cms.static_block.view',
        swagger: [
            'parameters' => [
                [
                    'name' => 'uuid',
                    'in' => 'path',
                    'default' => 'create',
                ]
            ]
        ]
    )]
    public function __invoke(Request $request, string $uuid = 'create'): JsonResponse
    {
        $data = [];

        if ('create' !== $uuid) {
            try {
                $item = $this->staticBlockRepository->findById($uuid);
                $data['item'] = $item->toArray();
            } catch (\Exception $e) {
                // ignore if _id doesn't exist
            }
        }

        if ('data-form' === $request->get('for')) {
            $data['data_form'] = $this->staticBlockForm->toArray();
        }

        return new JsonResponse($data);
    }
}
