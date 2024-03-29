<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EcommerceBundle\Seeder;

use EveryWorkflow\CatalogCategoryBundle\Repository\CatalogCategoryRepositoryInterface;
use EveryWorkflow\CatalogProductBundle\Repository\CatalogProductRepositoryInterface;
use EveryWorkflow\EavBundle\Repository\AttributeGroupRepositoryInterface;
use EveryWorkflow\EavBundle\Repository\AttributeRepositoryInterface;
use EveryWorkflow\MenuBundle\Repository\MenuRepositoryInterface;
use EveryWorkflow\MongoBundle\Support\SeederInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class Mongo_2023_01_01_00_00_00_Ecommerce_Seeder implements SeederInterface
{
    protected array $categories = [];
    protected array $productAttributes = [];

    public function __construct(
        protected SluggerInterface $slugger,
        protected AttributeRepositoryInterface $attributeRepository,
        protected AttributeGroupRepositoryInterface $attributeGroupRepository,
        protected MenuRepositoryInterface $menuRepository,
        protected CatalogCategoryRepositoryInterface $catalogCategoryRepository,
        protected CatalogProductRepositoryInterface $catalogProductRepository
    ) {
    }

    public function seed(): bool
    {
        $this->seedStoreMenu();
        $this->seedProductAttributes();
        $this->seedProductAttributeGroup();
        $this->seedCategories();
        $this->seedProducts();

        return self::SUCCESS;
    }

    public function rollback(): bool
    {
        $this->catalogProductRepository->deleteByFilter(['flags.is_created_via_seeder' => true]);
        $this->catalogCategoryRepository->deleteByFilter(['flags.is_created_via_seeder' => true]);
        $this->attributeRepository->deleteByFilter(['flags.is_created_via_seeder' => true]);
        $this->menuRepository->deleteByFilter(['flags.is_created_via_seeder' => true]);

        return self::SUCCESS;
    }

    protected function seedStoreMenu(): void
    {
        $menuBuilderData = json_decode('[
            {
              "item_label": "Category",
              "item_path": "/category"
            },
            {
              "item_label": "Product",
              "item_path": "/product"
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
            'flags' => [
                'is_created_via_seeder' => true,
            ],
        ]);
        $this->menuRepository->saveOne($frontendMenu);
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
            'gallery' => [
                'code' => 'gallery',
                'name' => 'Gallery',
                'type' => 'media_attribute',
                'field_type' => 'media_image_gallery_selector_field',
                'is_required' => false,
                'is_used_in_grid' => true,
                'is_used_in_form' => true,
                'sort_order' => 500,
            ],
            'color' => [
                'code' => 'color',
                'name' => 'Color',
                'type' => 'select_attribute',
                'is_required' => false,
                'is_searchable' => true,
                'is_used_in_grid' => true,
                'is_used_in_form' => true,
                'options' => $colorOptions,
                'sort_order' => 100,
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
                'sort_order' => 110,
            ],
        ];

        foreach ($this->productAttributes as $item) {
            $item['status'] = 'enable';
            $item['entity_code'] = $this->catalogProductRepository->getEntityCode();
            $item['flags'] = [
                'is_created_via_seeder' => true,
                'can_delete' => false,
            ];
            $attribute = $this->attributeRepository->create($item);
            $this->attributeRepository->saveOne($attribute);
        }
    }

    protected function seedProductAttributeGroup(): void
    {
        $groupData = [
            'name' => 'Default',
            'code' => 'default',
            'entity_code' => 'catalog_product',
            'status' => 'enable',
            'sort_order' => 1,
            'attribute_group_data' => [
                [
                    'code' => 'general',
                    'name' => 'General',
                    'sort_order' => 10,
                    'attributes' => [
                        'sku',
                        'name',
                        'url_key',
                    ],
                ],
                [
                    'code' => 'price',
                    'name' => 'Price',
                    'sort_order' => 20,
                    'attributes' => [
                        'price',
                        'special_price_from',
                        'special_price',
                        'special_price_to',
                    ],
                ],
                [
                    'code' => 'inventory',
                    'name' => 'Inventory',
                    'sort_order' => 30,
                    'attributes' => [
                        'quantity',
                    ],
                ],
                [
                    'code' => 'gallery',
                    'name' => 'Gallery',
                    'sort_order' => 300,
                    'attributes' => [
                        'gallery',
                    ],
                ],
                [
                    'code' => 'content',
                    'name' => 'Content',
                    'sort_order' => 500,
                    'attributes' => [
                        'short_description',
                        'description',
                    ],
                ],
                [
                    'code' => 'meta_information',
                    'name' => 'Meta Information',
                    'sort_order' => 1000,
                    'attributes' => [
                        'meta_title',
                        'meta_description',
                        'meta_keywords',
                    ],
                ],
            ],
            'flags' => [
                'is_created_via_seeder' => true,
                'can_delete' => false,
            ],
        ];

        $this->attributeGroupRepository->saveOne($this->attributeGroupRepository->create($groupData));

        $groupData['name'] = 'Clothing';
        $groupData['code'] = 'clothing';
        $groupData['sort_order'] = 10;
        $groupData['attribute_group_data'][] = [
            'code' => 'Product Information',
            'name' => 'product_information',
            'sort_order' => 100,
            'attributes' => [
                'color',
                'size',
            ],
        ];

        $this->attributeGroupRepository->saveOne($this->attributeGroupRepository->create($groupData));
    }

    protected function seedCategories(): void
    {
        // TODO: Need to seed multi level categories

        $faker = $faker = \Faker\Factory::create();
        for ($i = 1; $i < 10; ++$i) {
            $name = $faker->unique()->words(3, true);
            $slug = $this->slugger->slug($name)->toString();
            $name = ucwords($name);

            $categoryData = [
                'status' => 'enable',
                'name' => $name,
                'code' => $slug,
                'parent' => '---',
                'path' => $slug,
                'flags' => [
                    'is_created_via_seeder' => true,
                ],
            ];
            $this->categories[] = $categoryData;

            for ($j = 1; $j < 20; ++$j) {
                $name = $faker->unique()->words(3, true);
                $slug = $this->slugger->slug($name)->toString();
                $name = ucwords($name);

                $childCategoryData = [
                    'status' => 'enable',
                    'name' => $name,
                    'code' => $slug,
                    'parent' => $categoryData['code'],
                    'path' => $slug,
                    'flags' => [
                        'is_created_via_seeder' => true,
                    ],
                ];
                $this->categories[] = $childCategoryData;
            }
        }

        foreach ($this->categories as $item) {
            $document = $this->catalogCategoryRepository->create($item);
            $this->catalogCategoryRepository->saveOne($document);
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

        $timeNow = date('Y-m-d H:i:s');

        $faker = \Faker\Factory::create();
        for ($i = 1; $i < 100000; ++$i) {
            $name = $faker->unique()->words(rand(3, 6), true);
            $slug = $this->slugger->slug($name)->toString();
            $name = ucwords($name);

            $colorIndex = rand(0, $colorOptionLength - 1);
            $colorOption = $colorOptions[$colorIndex];

            $sizeIndex = rand(0, $sizeOptionLength - 1);
            $sizeOption = $sizeOptions[$sizeIndex];

            $categoryIndex = rand(0, $categoryLength - 1);
            $category = $this->categories[$categoryIndex] ?? [];

            $gallery = [];
            $galleryLength = rand(1, 8);
            for ($j = 1; $j <= $galleryLength; ++$j) {
                $imgName = $name.' - '.$j;
                $gallery[] = [
                    'path_name' => $faker->imageUrl(240, 240, $imgName, true),
                    'title' => $imgName,
                ];
            }

            $itemData[] = [
                'status' => 'enable',
                'name' => $name,
                'sku' => $slug,
                'category' => $category['code'] ?? '',
                'price' => $faker->numberBetween(1, 100000),
                'quantity' => $faker->numberBetween(0, 1000),
                'color' => $colorOption['code'] ?? '',
                'size' => $sizeOption['code'] ?? '',
                'gallery' => $gallery,
                'short_description' => $faker->sentences(rand(1, 3), true),
                'description' => $faker->paragraphs(rand(3, 6), true),
                'meta_title' => $name,
                'url_key' => $slug,
                'flags' => [
                    'is_created_via_seeder' => true,
                ],
                'created_at' => $timeNow,
                'updated_at' => $timeNow,
            ];

            if (count($itemData) > 1000) {
                $this->catalogProductRepository->getCollection()->insertMany($itemData);
                $itemData = [];
            }
        }
        if (count($itemData)) {
            $this->catalogProductRepository->getCollection()->insertMany($itemData);
            $itemData = [];
        }
    }
}
