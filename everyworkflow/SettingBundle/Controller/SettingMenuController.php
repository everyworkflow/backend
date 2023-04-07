<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\SettingBundle\Controller;

use EveryWorkflow\CoreBundle\Annotation\EwRoute;
use EveryWorkflow\SettingBundle\Model\SettingConfigProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class SettingMenuController extends AbstractController
{
    public function __construct(
        protected SettingConfigProviderInterface $settingConfigProvider
    ) {
    }

    #[EwRoute(
        path: 'setting/menu',
        name: 'setting.menu',
        methods: 'GET',
        priority: 10,
        permissions: 'setting.view',
        swagger: true
    )]
    public function __invoke(): JsonResponse
    {
        $menuData = $this->settingConfigProvider->get('menu');

        return new JsonResponse([
            'setting_menu_data' => $this->generateMenuTree($menuData),
        ]);
    }

    protected function generateMenuTree(array $menuData, string $parent = null): array
    {
        $menuTree = [];
        if ($parent) {
            $items = array_filter($menuData, fn ($item) => isset($item['parent']) && $item['parent'] === $parent);
        } else {
            $items = array_filter($menuData, fn ($item) => !isset($item['parent']) || empty($item['parent']));
        }

        foreach ($items as $key => $item) {
            if (isset($item['status']) && 'disable' === $item['status']) {
                continue;
            }
            $menuItemData = [
                'name' => $key,
                'item_label' => $item['label'] ?? $key,
            ];
            if ($parent) {
                $menuItemData['parent'] = $parent;
            }
            if (isset($item['form_class'])) {
                $menuItemData['item_path'] = '/setting/'.str_replace('.', '-', $key);
            }
            $menuItemData['item_type'] = $item['menu_type'] ?? null;
            $menuItemData['item_icon'] = $item['icon'] ?? null;
            $menuItemData['sort_order'] = $item['sort_order'] ?? null;
            $childrenItems = $this->generateMenuTree($menuData, $key);
            if (count($childrenItems)) {
                $menuItemData['children'] = $childrenItems;
            }
            $menuTree[] = $menuItemData;
        }

        uasort($menuTree, function ($a, $b) {
            $aSortOrder = $a['sort_order'] ?? null;
            $bSortOrder = $b['sort_order'] ?? null;
            if (null === $aSortOrder && null !== $bSortOrder) {
                return 1;
            }
            if ($aSortOrder > $bSortOrder) {
                return 1;
            }
            if ($aSortOrder < $bSortOrder) {
                return -1;
            }
        });

        return array_values($menuTree);
    }
}
