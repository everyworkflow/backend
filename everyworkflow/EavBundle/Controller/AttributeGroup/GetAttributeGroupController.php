<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Controller\AttributeGroup;

use EveryWorkflow\CoreBundle\Annotation\EwRoute;
use EveryWorkflow\EavBundle\Form\AttributeGroupFormInterface;
use EveryWorkflow\EavBundle\Repository\AttributeGroupRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class GetAttributeGroupController extends AbstractController
{
    public function __construct(
        protected AttributeGroupRepositoryInterface $attributeGroupRepository,
        protected AttributeGroupFormInterface $attributeGroupForm
    ) {
    }

    #[EwRoute(
        path: 'eav/attribute-group/{code}',
        name: 'eav.attribute_group.view',
        methods: 'GET',
        permissions: 'eav.attribute_group.view',
        swagger: [
            'tags' => ['eav_attribute_group'],
            'parameters' => [
                [
                    'name' => 'code',
                    'in' => 'path',
                    'default' => 'create',
                ],
            ],
        ]
    )]
    public function __invoke(Request $request, string $code = 'create'): JsonResponse
    {
        $data = [];

        if ('create' !== $code) {
            try {
                $item = $this->attributeGroupRepository->findOne(['code' => $code]);
                $data['item'] = $item->toArray();
            } catch (\Exception $e) {
                // ignore if _id doesn't exist
            }
        }

        if ('data-form' === $request->get('for')) {
            $data['data_form'] = $this->attributeGroupForm->toArray();
        }

        return new JsonResponse($data);
    }
}
