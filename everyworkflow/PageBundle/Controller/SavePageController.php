<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\PageBundle\Controller;

use EveryWorkflow\CoreBundle\Annotation\EwRoute;
use EveryWorkflow\PageBundle\Entity\PageEntityInterface;
use EveryWorkflow\PageBundle\Repository\PageRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class SavePageController extends AbstractController
{
    protected PageRepositoryInterface $pageRepository;

    public function __construct(PageRepositoryInterface $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    #[EwRoute(
        path: "cms/page/{uuid}",
        name: 'cms.page.save',
        methods: 'POST',
        permissions: 'cms.page.save',
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
                                'title' => [
                                    'type' => 'string',
                                    'required' => true,
                                ],
                                'url_path' => [
                                    'type' => 'string',
                                    'required' => true,
                                ],
                                'status' => [
                                    'value' => 'enable',
                                    'type' => 'string',
                                    'required' => true,
                                ],
                                'page_builder_data' => [
                                    'type' => 'json',
                                ],
                                'meta_title' => [
                                    'type' => 'string',
                                ],
                                'meta_description' => [
                                    'type' => 'string',
                                ],
                                'meta_keyword' => [
                                    'type' => 'string',
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
        $submitData = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        if ($uuid === 'create') {
            /** @var PageEntityInterface $item */
            $item = $this->pageRepository->create($submitData);
        } else {
            $item = $this->pageRepository->findById($uuid);
            foreach ($submitData as $key => $val) {
                $item->setData($key, $val);
            }
        }
        $item = $this->pageRepository->saveOne($item);

        return new JsonResponse([
            'detail' => 'Successfully saved changes.',
            'item' => $item->toArray(),
        ]);
    }
}
