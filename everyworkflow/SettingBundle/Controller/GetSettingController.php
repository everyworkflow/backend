<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\SettingBundle\Controller;

use EveryWorkflow\CoreBundle\Annotation\EwRoute;
use EveryWorkflow\DataFormBundle\Factory\FormFactoryInterface;
use EveryWorkflow\SettingBundle\Model\SettingConfigProviderInterface;
use EveryWorkflow\SettingBundle\Repository\SettingDocumentRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GetSettingController extends AbstractController
{
    public function __construct(
        protected SettingConfigProviderInterface $settingConfigProvider,
        protected FormFactoryInterface $formFactory,
        protected SettingDocumentRepositoryInterface $settingDocumentRepository
    ) {
    }

    #[EwRoute(
        path: 'setting/{urlKey}',
        name: 'setting.view',
        methods: 'GET',
        permissions: 'setting.view',
        swagger: true
    )]
    public function __invoke(Request $request, string $urlKey = 'general'): JsonResponse
    {
        $code = str_replace('-', '.', $urlKey);
        $settingData = $this->settingConfigProvider->getMenu($code);
        if (!isset($settingData['form_class'])) {
            throw new NotFoundHttpException('Setting not found.');
        }

        $responseData = [
            'label' => $settingData['label'] ?? '',
            'parent' => $settingData['parent'] ?? '',
        ];

        try {
            $item = $this->settingDocumentRepository->findByCode($code);
            $responseData['item'] = $item->toArray();
        } catch (\Exception $e) {
        }

        if ('data-form' === $request->get('for')) {
            $form = $this->formFactory->createByClassName($settingData['form_class']);
            if ($form) {
                $responseData['data_form'] = $form->toArray();
            }
        }

        return new JsonResponse($responseData);
    }
}
