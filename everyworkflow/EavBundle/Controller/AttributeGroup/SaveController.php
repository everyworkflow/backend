<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Controller\AttributeGroup;

use EveryWorkflow\CoreBundle\Annotation\EwRoute;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class SaveController extends AbstractController
{
    #[EwRoute(path: 'test', name: 'test', methods: 'GET')]
    public function __invoke(Request $request): JsonResponse
    {
        return new JsonResponse();
    }
}
