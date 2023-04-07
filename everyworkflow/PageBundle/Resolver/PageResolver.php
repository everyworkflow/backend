<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\PageBundle\Resolver;

use EveryWorkflow\PageBundle\Repository\PageRepositoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class PageResolver implements PageResolverInterface
{
    public function __construct(
        protected PageRepositoryInterface $pageRepository
    ) {
    }

    public function resolve($url, Request $request): JsonResponse
    {
        $pageDocument = $this->pageRepository->findOne(['url_path' => $url]);

        return new JsonResponse($pageDocument->toArray());
    }
}
