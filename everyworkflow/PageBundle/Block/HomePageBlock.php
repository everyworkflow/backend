<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\PageBundle\Block;

use EveryWorkflow\CoreBundle\Model\DataObjectInterface;
use EveryWorkflow\PageBuilderBundle\Block\ContainerBlock;
use EveryWorkflow\PageBuilderBundle\Factory\BlockFactoryInterface;

class HomePageBlock extends ContainerBlock implements HomePageBlockInterface
{
    protected BlockFactoryInterface $blockFactory;

    public function __construct(
        BlockFactoryInterface $blockFactory,
        DataObjectInterface $dataObject
    ) {
        parent::__construct($dataObject);
        $this->blockFactory = $blockFactory;
    }

    public function toArray(): array
    {
        $cardBlock = $this->blockFactory->createBlock([
            'block_type' => 'col_block',
            'span' => 6,
        ])->setBlocks([
            $this->blockFactory->createBlock([
                'block_type' => 'link_wrapper_block',
                'link_path' => '/contact',
                'link_target' => '_blank',
                "style" => '{"background": "#e6f7ff", "borderRadius": 8, "textAlign": "center", "boxShadow": "rgb(0 0 0 / 10%) 0px 1px 3px 0px, rgb(0 0 0 / 6%) 0px 1px 2px 0px"}',
            ])->setBlocks([
                $this->blockFactory->createBlock([
                    'block_type' => 'image_block',
                    'image' => [
                        'path_name' => '/media/page-cover/placeholder-image.png',
                        'thumbnail_path' => '/media/page-cover/_thumbnail/placeholder-image.png',
                        'title' => 'Image alt text',
                    ],
                    'style' => '{"borderRadius": "8px 8px 0 0"}',
                ]),
                $this->blockFactory->createBlock([
                    'block_type' => 'container_block',
                    "style" => '{"padding": 8}',
                ])->setBlocks([
                    $this->blockFactory->createBlock([
                        'block_type' => 'heading_block',
                        'heading_type' => 'h5',
                        'content' => 'What is Lorem Ipsum?',
                    ]),
                    $this->blockFactory->createBlock([
                        'block_type' => 'paragraph_block',
                        'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard.',
                    ]),
                ]),
            ]),
        ]);

        $blockData = [
            $this->blockFactory->createBlock([
                'block_type' => 'container_block',
                'container_type' => 'container-center',
                'style' => '{"backgroundColor": "#e6f7ff", "padding": "72px 0"}',
            ])->setBlocks([
                $this->blockFactory->createBlock([
                    'block_type' => 'row_block',
                    'justify' => 'center',
                    'align' => 'middle',
                    'style' => '{"backgroundColor": "#fff", "padding": 60, "borderRadius": 8, "boxShadow": "rgb(0 0 0 / 10%) 0px 1px 3px 0px, rgb(0 0 0 / 6%) 0px 1px 2px 0px"}',
                ])->setBlocks([
                    $this->blockFactory->createBlock([
                        'block_type' => 'col_block',
                        'span' => 12,
                    ])->setBlocks([
                        $this->blockFactory->createBlock([
                            'block_type' => 'heading_block',
                            'content' => 'Data platform',
                        ]),
                        $this->blockFactory->createBlock([
                            'block_type' => 'markdown_block',
                            'content' => "EveryWorkflow is bundle based data platform build using symfony and reactjs for modern data flow satisfying modern system needs.\n\n- Content management system\n- Customer relationship management\n- Product information management\n- Digital asset management\n- Ecommerce system\n",
                        ]),
                        $this->blockFactory->createBlock([
                            'block_type' => 'button_block',
                            'button_label' => 'Know more',
                            'button_path' => '/contact',
                            'button_type' => 'primary',
                            'button_size' => 'large',
                        ]),
                    ]),
                    $this->blockFactory->createBlock([
                        'block_type' => 'col_block',
                        'span' => 12,
                        'style' => '{"textAlign": "center"}',
                    ])->setBlocks([
                        $this->blockFactory->createBlock([
                            'block_type' => 'image_block',
                            'image' => [
                                'path_name' => '/media/page-cover/first.png',
                                'thumbnail_path' => '/media/page-cover/_thumbnail/first.png',
                                'title' => 'Image alt text',
                            ],
                        ]),
                        $this->blockFactory->createBlock([
                            'block_type' => 'paragraph_block',
                            'content' => 'One platform to build every thing',
                        ]),
                    ]),
                ]),
            ])->toArray(),
            $this->blockFactory->createBlock([
                'block_type' => 'container_block',
                'container_type' => 'container-center',
                'style' => '{"backgroundColor": "#fff", "padding": "42px 0"}',
            ])->setBlocks([
                $this->blockFactory->createBlock([
                    'block_type' => 'row_block',
                    'justify' => 'center',
                    'align' => 'middle',
                    'gutter' => '42',
                ])->setBlocks([
                    $cardBlock,
                    $cardBlock,
                    $cardBlock,
                    $cardBlock,
                ]),
            ])->toArray(),
            $this->blockFactory->createBlock([
                'block_type' => 'container_block',
                'container_type' => 'container-center',
                'style' => '{"padding": "80px 0"}',
            ])->setBlocks([
                $this->blockFactory->createBlock([
                    'block_type' => 'heading_block',
                    'heading_type' => 'h1',
                    'content' => '"We need to stop interrupting what people are interested in and be what people are interested in."',
                    'style' => '{"padding": "0 140px"}',
                ]),
                $this->blockFactory->createBlock([
                    'block_type' => 'paragraph_block',
                    'content' => '- Craig Davis',
                    'style' => '{"textAlign": "right", "padding": "0 140px"}',
                ]),
            ])->toArray(),
            $this->blockFactory->createBlock([
                'block_type' => 'container_block',
                'container_type' => 'container-center',
                'style' => '{"marginBottom": "28px"}',
            ])->setBlocks([
                $this->blockFactory->createBlock([
                    'block_type' => 'image_block',
                    'image' => [
                        'path_name' => '/media/page-cover/screenshot.png',
                        'thumbnail_path' => '/media/page-cover/_thumbnail/screenshot.png',
                        'title' => 'Image alt text',
                    ],
                    'style' => '{"border": "solid 2px #888", "borderTop": "2px solid rgb(136, 136, 136)", "borderRadius": "12px", "boxShadow": "rgb(0 0 0 / 10%) 0px 10px 15px -3px, rgb(0 0 0 / 5%) 0px 4px 6px -2px"}',
                ]),
                $this->blockFactory->createBlock([
                    'block_type' => 'container_block',
                    'style' => '{"textAlign": "center", "padding": "28px 0"}',
                ])->setBlocks([
                    $this->blockFactory->createBlock([
                        'block_type' => 'button_block',
                        'button_label' => 'Contact us',
                        'button_path' => '/contact',
                        'button_type' => 'primary',
                        'button_size' => 'large',
                    ]),
                ]),
            ])->toArray(),
        ];

        $data = parent::toArray();
        $data[self::KEY_BLOCK_DATA] = $blockData;
        return $data;
    }
}
