<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Controller\Attribute;

use EveryWorkflow\CoreBundle\Annotation\EwRoute;
use EveryWorkflow\DataFormBundle\Factory\FormFactoryInterface;
use EveryWorkflow\EavBundle\Form\AttributeFormInterface;
use EveryWorkflow\EavBundle\Model\EavConfigProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AdditionalFormController extends AbstractController
{
    public function __construct(
        protected AttributeFormInterface $attributeForm,
        protected EavConfigProviderInterface $eavConfigProvider,
        protected FormFactoryInterface $formFactory
    ) {
    }

    #[EwRoute(
        path: 'eav/attribute/additional-form',
        name: 'eav.attribute.additional_form',
        methods: 'POST',
        priority: 5,
        permissions: 'eav.attribute.view',
        swagger: [
            'tags' => ['eav_attribute'],
        ]
    )]
    public function __invoke(Request $request): JsonResponse
    {
        $submitData = $request->toArray();
        $type = (string) $submitData['type'] ?? '';

        $attributeFormClass = $this->eavConfigProvider->get('attribute_forms.' . $type);
        if (!$attributeFormClass) {
            return new JsonResponse([
                'data_form' => $this->attributeForm->toArray(),
            ]);
        }

        $form = $this->formFactory->createByClassName($attributeFormClass);

        return new JsonResponse([
            'data_form' => $form->toArray(),
        ]);
    }
}
