<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Controller\AttributeGroup;

use EveryWorkflow\CoreBundle\Annotation\EwRoute;
use EveryWorkflow\EavBundle\Form\AttributeGroupFormInterface;
use EveryWorkflow\EavBundle\Repository\AttributeRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AdditionalFormController extends AbstractController
{
    public function __construct(
        protected AttributeGroupFormInterface $attributeGroupForm,
        protected AttributeRepositoryInterface $attributeRepository
    ) {
    }

    #[EwRoute(
        path: 'eav/attribute-group/additional-form',
        name: 'eav.attribute_group.additional_form',
        methods: 'POST',
        priority: 5,
        permissions: 'eav.attribute_group.view',
        swagger: [
            'tags' => ['eav_attribute_group'],
        ]
    )]
    public function __invoke(Request $request): JsonResponse
    {
        $data = [
            'data_form' => $this->attributeGroupForm->toArray(),
        ];

        $submitData = $request->toArray();
        $entityCode = (string) $submitData['entity_code'] ?? '';
        $data['entity_code'] = $entityCode;
        $data['data_form']['additional_data']['entity_code'] = $entityCode;

        $filter = ['entity_code' => $entityCode];
        $options = [
            'projection' => [
                '_id' => 1,
                'status' => 1,
                'code' => 1,
                'name' => 1,
                'entity_code' => 1,
                'type' => 1,
                'sort_order' => 1,
            ],
        ];
        $attributes = $this->attributeRepository->find($filter, $options);
        $attributeItems = [];
        foreach ($attributes as $item) {
            $attributeItems[] = $item->toArray();
        }
        $data['data_form']['additional_data']['attributes'] = $attributeItems;

        return new JsonResponse($data);
    }
}
