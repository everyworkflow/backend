<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\PageBuilderBundle\Controller;

use EveryWorkflow\CoreBundle\Annotation\EwRoute;
use EveryWorkflow\PageBuilderBundle\Factory\BlockFormFactoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class BlockFormController extends AbstractController
{
    protected BlockFormFactoryInterface $blockFormFactory;

    public function __construct(BlockFormFactoryInterface $blockFormFactory)
    {
        $this->blockFormFactory = $blockFormFactory;
    }

    #[EwRoute(
        path: "page-builder/block-form/{blockType}",
        name: 'page_builder.block_form.block_type',
        methods: 'GET',
        swagger: [
            'parameters' => [
                [
                    'name' => 'blockType',
                    'in' => 'path',
                ]
            ]
        ]
    )]
    public function __invoke($blockType): JsonResponse
    {
        $form = $this->blockFormFactory->createFormForBlockType($blockType);
        $data = [
            'title' => str_replace('_', ' ', ucfirst($blockType)),
            'block_type' => $blockType,
            'data_form' => $form->toArray(),
        ];
        return new JsonResponse($data);
    }
}
