<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Controller\AttributeGroup;

use EveryWorkflow\CoreBundle\Annotation\EwRoute;
use EveryWorkflow\EavBundle\Repository\AttributeGroupRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class SaveAttributeGroupController extends AbstractController
{
    public function __construct(
        protected AttributeGroupRepositoryInterface $attributeGroupRepository
    ) {
    }

    #[EwRoute(
        path: 'eav/attribute-group/{code}',
        name: 'eav.attribute_group.save',
        methods: 'POST',
        permissions: 'eav.attribute_group.save',
        swagger: [
            'parameters' => [
                [
                    'name' => 'code',
                    'in' => 'path',
                    'default' => 'create',
                ],
            ],
            'requestBody' => [
                'content' => [
                    'application/json' => [
                        'schema' => [
                            'properties' => [],
                        ],
                    ],
                ],
            ],
        ]
    )]
    public function __invoke(Request $request, string $code = 'create'): JsonResponse
    {
        $submitData = $request->toArray();

        /* @var EntityDocumentInterface $entity */
        if ('create' === $code) {
            if (isset($submitData['code'])) {
                try {
                    $entityByCode = $this->attributeGroupRepository->findOne([
                        'code' => $submitData['code'],
                    ]);
                    if ($entityByCode) {
                        return new JsonResponse([
                            'message' => 'Entity with code ' . $submitData['code'] . ' already exists.',
                        ], JsonResponse::HTTP_BAD_REQUEST);
                    }
                } catch (\Exception $e) {
                    // ignore if entity code doesn't exist
                }
            }
            $item = $this->attributeGroupRepository->create($submitData);
        } else {
            $item = $this->attributeGroupRepository->findOne(['code' => $code]);
            foreach ($submitData as $key => $val) {
                $item->setData($key, $val);
            }
        }

        $item = $this->attributeGroupRepository->saveOne($item);

        return new JsonResponse([
            'detail' => 'Successfully saved changes.',
            'item' => $item->toArray(),
        ]);
    }
}
