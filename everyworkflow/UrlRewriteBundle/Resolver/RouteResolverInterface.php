<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\UrlRewriteBundle\Resolver;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

interface RouteResolverInterface
{
    public function resolve(string $url, Request $request): JsonResponse;
}
