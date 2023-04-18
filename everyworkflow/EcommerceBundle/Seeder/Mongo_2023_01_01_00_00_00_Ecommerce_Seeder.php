<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EcommerceBundle\Seeder;

use EveryWorkflow\CatalogCategoryBundle\Repository\CatalogCategoryRepositoryInterface;
use EveryWorkflow\CatalogProductBundle\Repository\CatalogProductRepositoryInterface;
use EveryWorkflow\EavBundle\Repository\AttributeRepositoryInterface;
use EveryWorkflow\MenuBundle\Repository\MenuRepositoryInterface;
use EveryWorkflow\MongoBundle\Support\SeederInterface;

class Mongo_2023_01_01_00_00_00_Ecommerce_Seeder implements SeederInterface
{
    protected array $categories = [];
    protected array $productAttributes = [];

    public function __construct(
        protected AttributeRepositoryInterface $attributeRepository,
        protected MenuRepositoryInterface $menuRepository,
        protected CatalogCategoryRepositoryInterface $catalogCategoryRepository,
        protected CatalogProductRepositoryInterface $catalogProductRepository
    ) {
    }

    public function seed(): bool
    {
        $this->seedStoreMenu();
        // $this->seedCategories();
        // $this->seedProductAttributes();
        // $this->seedProducts();

        return self::SUCCESS;
    }

    public function rollback(): bool
    {
        $this->menuRepository->deleteByFilter(['code' => 'store_panel_menu']);
        // $this->catalogCategoryRepository->getCollection()->drop();
        // $this->attributeRepository->deleteByFilter(['flag.is_created_via_seeder' => true]);
        // $this->catalogProductRepository->getCollection()->drop();

        return self::SUCCESS;
    }

    protected function seedStoreMenu(): void
    {
        $menuBuilderData = json_decode('[
            {
              "item_label": "Product",
              "item_path": "/product"
            },
            {
              "item_label": "Product single",
              "item_path": "/product/single"
            },
            {
              "item_label": "About",
              "item_path": "/about"
            },
            {
              "item_label": "Contact",
              "item_path": "/contact"
            },
            {
              "item_label": "Examples",
              "item_path": "/examples",
              "children": [
                {
                  "item_label": "Privacy policy",
                  "item_path": "/privacy-policy"
                },
                {
                  "item_label": "Terms of use",
                  "item_path": "/terms-of-use"
                }
              ]
            }
          ]', true);

        $frontendMenu = $this->menuRepository->create([
            'name' => 'Store panel menu',
            'code' => 'store_panel_menu',
            'status' => 'enable',
            'menu_builder_data' => $menuBuilderData,
        ]);
        $this->menuRepository->saveOne($frontendMenu);
    }

    protected function seedCategories(): void
    {
        for ($i = 1; $i < 50; ++$i) {
            $this->categories[] = [
                'status' => 'enable',
                'name' => 'Category - '.$i,
                'code' => 'category-'.$i,
                'path' => 'category-'.$i,
            ];
        }

        foreach ($this->categories as $item) {
            $document = $this->catalogCategoryRepository->create($item);
            $this->catalogCategoryRepository->saveOne($document);
        }
    }

    protected function seedProductAttributes(): void
    {
        $colorOptions = [
            [
                'code' => 'red',
                'label' => 'Red',
                'option_type' => 'color_swatch',
                'sort_order' => 1,
                'color_swatch' => '#ff0000',
            ],
            [
                'code' => 'blue',
                'label' => 'Blue',
                'option_type' => 'color_swatch',
                'sort_order' => 2,
                'color_swatch' => '#0000ff',
            ],
            [
                'code' => 'green',
                'label' => 'Green',
                'option_type' => 'color_swatch',
                'sort_order' => 3,
                'color_swatch' => '#00ff00',
            ],
            [
                'code' => 'orange',
                'label' => 'Orange',
                'option_type' => 'color_swatch',
                'sort_order' => 4,
                'color_swatch' => '#ffa500',
            ],
            [
                'code' => 'pink',
                'label' => 'Pink',
                'option_type' => 'color_swatch',
                'sort_order' => 5,
                'color_swatch' => '#ffc0cb',
            ],
            [
                'code' => 'purple',
                'label' => 'Purple',
                'option_type' => 'color_swatch',
                'sort_order' => 6,
                'color_swatch' => '#800080',
            ],
            [
                'code' => 'yellow',
                'label' => 'Yellow',
                'option_type' => 'color_swatch',
                'sort_order' => 7,
                'color_swatch' => '#ffff00',
            ],
            [
                'code' => 'golden',
                'label' => 'Golden',
                'option_type' => 'color_swatch',
                'sort_order' => 8,
                'color_swatch' => '#ffd700',
            ],
            [
                'code' => 'black',
                'label' => 'Black',
                'option_type' => 'color_swatch',
                'sort_order' => 9,
                'color_swatch' => '#000000',
            ],
            [
                'code' => 'brown',
                'label' => 'Brown',
                'option_type' => 'color_swatch',
                'sort_order' => 10,
                'color_swatch' => '#804000',
            ],
            [
                'code' => 'gray',
                'label' => 'Gray',
                'option_type' => 'color_swatch',
                'sort_order' => 11,
                'color_swatch' => '#808080',
            ],
            [
                'code' => 'white',
                'label' => 'White',
                'option_type' => 'color_swatch',
                'sort_order' => 12,
                'color_swatch' => '#ffffff',
            ],
        ];
        $sizeOptions = [
            [
                'code' => 's',
                'label' => 'S',
                'option_type' => 'text_swatch',
                'sort_order' => 1,
                'text_swatch' => 'S',
            ],
            [
                'code' => 'm',
                'label' => 'M',
                'option_type' => 'text_swatch',
                'sort_order' => 2,
                'text_swatch' => 'M',
            ],
            [
                'code' => 'l',
                'label' => 'L',
                'option_type' => 'text_swatch',
                'sort_order' => 3,
                'text_swatch' => 'L',
            ],
            [
                'code' => 'xs',
                'label' => 'XS',
                'option_type' => 'text_swatch',
                'sort_order' => 4,
                'text_swatch' => 'XS',
            ],
            [
                'code' => 'xxs',
                'label' => 'XXS',
                'option_type' => 'text_swatch',
                'sort_order' => 5,
                'text_swatch' => 'XXS',
            ],
            [
                'code' => 'xl',
                'label' => 'XL',
                'option_type' => 'text_swatch',
                'sort_order' => 6,
                'text_swatch' => 'XL',
            ],
            [
                'code' => 'xxl',
                'label' => 'XXL',
                'option_type' => 'text_swatch',
                'sort_order' => 7,
                'text_swatch' => 'XXL',
            ],
        ];
        $this->productAttributes = [
            'color' => [
                'code' => 'color',
                'name' => 'Color',
                'type' => 'select_attribute',
                'is_required' => false,
                'is_searchable' => true,
                'is_used_in_grid' => true,
                'is_used_in_form' => true,
                'options' => $colorOptions,
            ],
            'size' => [
                'code' => 'size',
                'name' => 'Size',
                'type' => 'select_attribute',
                'is_required' => false,
                'is_searchable' => true,
                'is_used_in_grid' => true,
                'is_used_in_form' => true,
                'options' => $sizeOptions,
            ],
        ];

        $sortOrder = 100;
        foreach ($this->productAttributes as $item) {
            $item['status'] = 'enable';
            $item['entity_code'] = $this->catalogProductRepository->getEntityCode();
            $item['sort_order'] = $sortOrder++;
            $item['flag.is_created_via_seeder'] = true;
            $attribute = $this->attributeRepository->create($item);
            $this->attributeRepository->saveOne($attribute);
        }
    }

    protected function seedProducts(): void
    {
        $itemData = [];

        $colorAttribute = $this->productAttributes['color'] ?? [];
        $colorOptions = $colorAttribute['options'] ?? [];

        $sizeAttribute = $this->productAttributes['size'] ?? [];
        $sizeOptions = $sizeAttribute['options'] ?? [];

        $colorOptionLength = count($colorOptions);
        $sizeOptionLength = count($sizeOptions);

        $categoryLength = count($this->categories);

        for ($i = 1; $i < 5000; ++$i) {
            $colorIndex = rand(0, $colorOptionLength - 1);
            $colorOption = $colorOptions[$colorIndex];

            $sizeIndex = rand(0, $sizeOptionLength - 1);
            $sizeOption = $sizeOptions[$sizeIndex];

            $categoryIndex = rand(0, $categoryLength - 1);
            $category = $this->categories[$categoryIndex] ?? [];

            $itemData[] = [
                'status' => 'enable',
                'name' => 'Product Name - '.$i,
                'sku' => 'sku-'.$i,
                'category' => $category['code'] ?? '',
                'price' => 5 * $i,
                'quantity' => 1000 + $i,
                'color' => $colorOption['code'] ?? '',
                'size' => $sizeOption['code'] ?? '',
                'short_description' => 'This is just a short description. '.$i,
                'description' => 'This is just a description. '.$i,
                'meta_title' => 'Product Name - '.$i,
                'url_key' => 'sku-'.$i,
                'flag.is_created_via_seeder' => true,
            ];
        }

        foreach ($itemData as $item) {
            $document = $this->catalogProductRepository->create($item);
            $this->catalogProductRepository->saveOne($document);
        }
    }
}
