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
use Symfony\Component\HttpFoundation\Request;

class SaveStaticBlockController extends AbstractController
{
    protected StaticBlockRepositoryInterface $staticBlockRepository;

    public function __construct(StaticBlockRepositoryInterface $staticBlockRepository)
    {
        $this->staticBlockRepository = $staticBlockRepository;
    }

    #[EwRoute(
        path: "cms/static-block/{uuid}",
        name: 'cms.static_block.save',
        methods: 'POST',
        permissions: 'cms.static_block.save',
        swagger: [
            'parameters' => [
                [
                    'name' => 'uuid',
                    'in' => 'path',
                    'default' => 'create',
                ]
            ],
            'requestBody' => [
                'content' => [
                    'application/json' => [
                        'schema' => [
                            'properties' => [
                                'block_title' => [
                                    'type' => 'string',
                                    'required' => true,
                                ],
                                'block_key' => [
                                    'type' => 'string',
                                    'required' => true,
                                ],
                                'page_builder_data' => [
                                    'type' => 'json',
                                ],
                            ]
                        ]
                    ]
                ]
            ]
        ]
    )]
    public function __invoke(Request $request, string $uuid = 'create'): JsonResponse
    {
        $submitData = json_decode($request->getContent(), true);

        if ('create' === $uuid) {
            if (isset($submitData['section_key'])) {
                try {
                    $itemByKey = $this->staticBlockRepository->findOne(['block_key' => $submitData['block_key']]);
                    if ($itemByKey) {
                        return new JsonResponse([
                            'message' => "Static block with key '${submitData['block_key']}' already exists.",
                        ], JsonResponse::HTTP_BAD_REQUEST);
                    }
                } catch (\Exception $e) {
                    // ignore if section_key doesn't exist
                }
            }
            $item = $this->staticBlockRepository->create($submitData);
        } else {
            $item = $this->staticBlockRepository->findById($uuid);
            foreach ($submitData as $key => $val) {
                $item->setData($key, $val);
            }
        }

        $item = $this->staticBlockRepository->saveOne($item);

        return new JsonResponse([
            'detail' => 'Successfully saved changes.',
            'item' => $item->toArray(),
        ]);
    }
}
