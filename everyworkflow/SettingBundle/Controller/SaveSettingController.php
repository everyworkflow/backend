<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\SettingBundle\Controller;

use EveryWorkflow\CoreBundle\Annotation\EwRoute;
use EveryWorkflow\SettingBundle\Repository\SettingDocumentRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class SaveSettingController extends AbstractController
{
    protected SettingDocumentRepositoryInterface $settingDocumentRepository;

    public function __construct(SettingDocumentRepositoryInterface $settingDocumentRepository)
    {
        $this->settingDocumentRepository = $settingDocumentRepository;
    }

    #[EwRoute(
        path: "setting/{urlKey}",
        name: 'setting.save',
        methods: 'POST',
        permissions: 'setting.save',
        swagger: true
    )]
    public function __invoke(Request $request, string $urlKey): JsonResponse
    {
        $submitData = json_decode($request->getContent(), true);
        $code = str_replace('-', '.', $urlKey);

        try {
            $item = $this->settingDocumentRepository->findByCode($code);
            foreach ($submitData as $key => $val) {
                $item->setData($key, $val);
            }
        } catch (\Exception $e) {
            $item = $this->settingDocumentRepository->create([
                'code' => $code,
                ...$submitData,
            ]);
        }

        try {
            $setting = $this->settingDocumentRepository->saveOne($item);
            return new JsonResponse([
                'detail' => 'Successfully saved changes.',
                'item' => $setting->toArray()
            ]);
        } catch (\Exception $e) {
            return new JsonResponse([
                'detail' => $e->getMessage(),
            ], 500);
        }
    }
}
