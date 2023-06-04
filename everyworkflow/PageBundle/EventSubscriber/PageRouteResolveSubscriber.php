<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\PageBundle\EventSubscriber;

use EveryWorkflow\UrlRewriteBundle\Event\RouteResolveEventInterface;
use EveryWorkflow\PageBundle\Repository\PageRepositoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class PageRouteResolveSubscriber implements EventSubscriberInterface, PageRouteResolveSubscriberInterface
{
    public function __construct(
        protected PageRepositoryInterface $pageRepository
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'route_resolve_type_page' => 'resolveRoute',
        ];
    }

    public function resolveRoute(RouteResolveEventInterface $event): void
    {
        $response = $event->getResponse();
        $urlRewrite = $event->getUrlRewrite();
        $responseData = $urlRewrite->toArray();
        
        $document = $this->pageRepository->findOne(['url_path' => $urlRewrite->getUrl()]);
        $responseData['item'] = $document->toArray();

        $response->setData($responseData);
    }
}
