<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\UrlRewriteBundle\Event;

use EveryWorkflow\UrlRewriteBundle\Document\UrlRewriteDocumentInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class RouteResolveEvent implements RouteResolveEventInterface
{
    public const EVENT_PREFIX_KEY = 'route_resolve_type';

    public function __construct(
        protected JsonResponse $response,
        protected Request $request,
        protected UrlRewriteDocumentInterface $urlRewrite
    ) {
    }

    public function getResponse(): JsonResponse
    {
        return $this->response;
    }

    public function setResponse(JsonResponse $response): self
    {
        $this->response = $response;
        return $this;
    }

    public function getRequest(): Request
    {
        return $this->request;
    }

    public function setRequest(Request $request): self
    {
        $this->request = $request;
        return $this;
    }

    public function getUrlRewrite(): UrlRewriteDocumentInterface
    {
        return $this->urlRewrite;
    }

    public function setUrlRewrite(UrlRewriteDocumentInterface $urlRewrite): self
    {
        $this->urlRewrite = $urlRewrite;
        return $this;
    }
}
