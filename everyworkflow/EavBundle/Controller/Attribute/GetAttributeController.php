<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Controller\Attribute;

use EveryWorkflow\CoreBundle\Annotation\EwRoute;
use EveryWorkflow\EavBundle\Form\AttributeFormInterface;
use EveryWorkflow\EavBundle\Repository\AttributeRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class GetAttributeController extends AbstractController
{
    public function __construct(
        protected AttributeRepositoryInterface $attributeRepository,
        protected AttributeFormInterface $attributeForm
    ) {
    }

    #[EwRoute(
        path: 'eav/attribute/{code}',
        name: 'eav.attribute.view',
        methods: 'GET',
        permissions: 'eav.attribute.view',
        swagger: [
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
            $entity = $this->attributeRepository->findOne(['code' => $code]);
            $data['item'] = $entity->toArray();
        }

        if ('data-form' === $request->get('for')) {
            $data['data_form'] = $this->attributeForm->toArray();
        }

        return new JsonResponse($data);
    }
}
