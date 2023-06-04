<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\UrlRewriteBundle\Resolver;

use EveryWorkflow\UrlRewriteBundle\Repository\UrlRewriteRepositoryInterface;
use EveryWorkflow\UrlRewriteBundle\Event\RouteResolveEvent;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class RouteResolver implements RouteResolverInterface
{
    public function __construct(
        protected UrlRewriteRepositoryInterface $urlRewriteRepository,
        protected EventDispatcherInterface $eventDispatcher
    ) {
    }

    public function resolve(string $url, Request $request): JsonResponse
    {
        $response = new JsonResponse();
        try {
            $urlRewrite = $this->urlRewriteRepository->findOne(['url' => $url]);
            $response->setData($urlRewrite->toArray());

            $eventKey = RouteResolveEvent::EVENT_PREFIX_KEY . '_' . $urlRewrite->getData('type');
            $event = new RouteResolveEvent($response, $request, $urlRewrite);
            $this->eventDispatcher->dispatch($event, $eventKey);

            return $response;
        } catch (NotFoundResourceException $e) {
            return $response->setData(['message' => 'Route not found.'])
                ->setStatusCode(JsonResponse::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            return $response->setData(['message' => $e->getMessage()])
                ->setStatusCode(JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
