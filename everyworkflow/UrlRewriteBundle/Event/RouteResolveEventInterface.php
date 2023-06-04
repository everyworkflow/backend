<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\UrlRewriteBundle\Event;

use EveryWorkflow\UrlRewriteBundle\Document\UrlRewriteDocumentInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

interface RouteResolveEventInterface
{
    public function getResponse(): JsonResponse;

    public function setResponse(JsonResponse $response): self;

    public function getRequest(): Request;

    public function setRequest(Request $request): self;

    public function getUrlRewrite(): UrlRewriteDocumentInterface;

    public function setUrlRewrite(UrlRewriteDocumentInterface $urlRewrite): self;
}
