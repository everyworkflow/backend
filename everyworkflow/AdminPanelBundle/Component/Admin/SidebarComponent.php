<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\AdminPanelBundle\Component\Admin;

use EveryWorkflow\AdminPanelBundle\Model\AdminPanelConfigProviderInterface;

class SidebarComponent implements SidebarComponentInterface
{
    protected AdminPanelConfigProviderInterface $adminPanelConfigProvider;

    public function __construct(
        AdminPanelConfigProviderInterface $adminPanelConfigProvider
    ) {
        $this->adminPanelConfigProvider = $adminPanelConfigProvider;
    }

    public function getData(): ?array
    {
        $menuData = $this->adminPanelConfigProvider->get('sidebar_menu');

        $data = [
            'sidebar_data' => $this->generateMenuTree($menuData),
        ];

        return $data;
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
            if (isset($item['status']) && $item['status'] === 'disable') {
                continue;
            }
            $menuItemData = [
                'name' => $key,
                'item_label' => $item['label'] ?? $key,
            ];
            if ($parent) {
                $menuItemData['parent'] = $parent;
            }
            $menuItemData['item_path'] = $item['path'] ?? null;
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
            if ($aSortOrder === null && $bSortOrder !== null) return 1;
            if ($aSortOrder > $bSortOrder) return 1;
            if ($aSortOrder < $bSortOrder) return -1;
        });

        return array_values($menuTree);
    }
}
