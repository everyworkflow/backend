<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Controller\Attribute;

use EveryWorkflow\CoreBundle\Annotation\EwRoute;
use EveryWorkflow\EavBundle\Repository\AttributeRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class SaveAttributeController extends AbstractController
{
    protected AttributeRepositoryInterface $attributeRepository;

    public function __construct(AttributeRepositoryInterface $attributeRepository)
    {
        $this->attributeRepository = $attributeRepository;
    }

    #[EwRoute(
        path: "eav/attribute/{code}",
        name: 'eav.attribute.save',
        methods: 'POST',
        permissions: 'eav.attribute.save',
        swagger: [
            'parameters' => [
                [
                    'name' => 'code',
                    'in' => 'path',
                    'default' => 'create',
                ]
            ],
            'requestBody' => [
                'content' => [
                    'application/json' => [
                        'schema' => [
                            'properties' => [
                                'code' => [
                                    'type' => 'string',
                                    'required' => true,
                                ],
                                'name' => [
                                    'type' => 'string',
                                    'required' => true,
                                ],
                                'type' => [
                                    'type' => 'string',
                                    'required' => true,
                                ],
                                'class' => [
                                    'type' => 'string',
                                    'required' => true,
                                ],
                                'entity_code' => [
                                    'type' => 'string',
                                    'required' => true,
                                ],
                                'is_required' => [
                                    'type' => 'boolean',
                                    'default' => false,
                                ],
                                'is_readonly' => [
                                    'type' => 'boolean',
                                    'default' => false,
                                ],
                                'is_used_in_grid' => [
                                    'type' => 'boolean',
                                    'default' => false,
                                ],
                                'is_used_in_form' => [
                                    'type' => 'boolean',
                                    'default' => false,
                                ],
                                'sort_order' => [
                                    'type' => 'number',
                                    'required' => true,
                                ],
                            ]
                        ]
                    ]
                ]
            ]
        ]
    )]
    public function __invoke(Request $request, string $code = 'create'): JsonResponse
    {
        $submitData = json_decode($request->getContent(), true);
        if ('create' === $code) {
            $item = $this->attributeRepository->create($submitData);
        } else {
            $item = $this->attributeRepository->findOne(['code' => $code]);
            foreach ($submitData as $key => $val) {
                $item->setData($key, $val);
            }
        }

        $item = $this->attributeRepository->saveOne($item);

        return new JsonResponse([
            'detail' => 'Successfully saved changes.',
            'item' => $item->toArray(),
        ]);
    }
}
