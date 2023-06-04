<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CatalogProductBundle\EventSubscriber;

use EveryWorkflow\CatalogProductBundle\Repository\CatalogProductRepositoryInterface;
use EveryWorkflow\UrlRewriteBundle\Event\RouteResolveEventInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ProductRouteResolveSubscriber implements EventSubscriberInterface, ProductRouteResolveSubscriberInterface
{
    public function __construct(
        protected CatalogProductRepositoryInterface $catalogProductRepository
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'route_resolve_type_catalog_product' => 'resolveRoute',
        ];
    }

    public function resolveRoute(RouteResolveEventInterface $event): void
    {
        $response = $event->getResponse();
        $urlRewrite = $event->getUrlRewrite();
        $responseData = $urlRewrite->toArray();
        
        $document = $this->catalogProductRepository->findOne(['url_key' => $urlRewrite->getUrl()]);
        $responseData['item'] = $document->toArray();

        $response->setData($responseData);
    }
}
