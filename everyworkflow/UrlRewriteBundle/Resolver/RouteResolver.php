<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\UrlRewriteBundle\Resolver;

use EveryWorkflow\PageBundle\Resolver\PageResolverInterface;
use EveryWorkflow\UrlRewriteBundle\Repository\UrlRewriteRepositoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class RouteResolver implements RouteResolverInterface
{
    protected UrlRewriteRepositoryInterface $urlRewriteRepository;
    protected PageResolverInterface $pageResolver;

    public function __construct(
        UrlRewriteRepositoryInterface $urlRewriteRepository,
        PageResolverInterface $pageResolver
    ) {
        $this->urlRewriteRepository = $urlRewriteRepository;
        $this->pageResolver = $pageResolver;
    }

    public function resolve($url, Request $request): JsonResponse
    {
        try {
            // $urlRewrite = $this->urlRewriteRepository->findOne(['url' => $url]);
            return $this->pageResolver->resolve($url, $request);
        } catch (\Exception $e) {
            return (new JsonResponse())->setData(['message' => 'Page not found.'])
                ->setStatusCode(JsonResponse::HTTP_NOT_FOUND);
        }
    }
}
