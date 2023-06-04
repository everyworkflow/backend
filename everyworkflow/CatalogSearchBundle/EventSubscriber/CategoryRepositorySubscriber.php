<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CatalogSearchBundle\EventSubscriber;

use EveryWorkflow\CatalogCategoryBundle\Repository\CatalogCategoryRepositoryInterface;
use EveryWorkflow\CatalogSearchBundle\Controller\CatalogSearchController;
use EveryWorkflow\UrlRewriteBundle\Event\RouteResolveEventInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CategoryRepositorySubscriber implements EventSubscriberInterface, CategoryRepositorySubscriberInterface
{
    public function __construct(
        protected CatalogCategoryRepositoryInterface $catalogCategoryRepository,
        protected CatalogSearchController $catalogSearchController
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'route_resolve_type_catalog_category' => 'resolveRoute',
        ];
    }

    public function resolveRoute(RouteResolveEventInterface $event): void
    {
        $request = $event->getRequest();
        $response = $event->getResponse();
        $urlRewrite = $event->getUrlRewrite();
        $responseData = $urlRewrite->toArray();

        $document = $this->catalogCategoryRepository->findOne(['path' => $urlRewrite->getUrl()]);
        $responseData['item'] = $document->toArray();
        
        $result = $this->catalogSearchController->__invoke($request, $document->getData('code'));
        if ($result->getStatusCode() === 200) {
            $jsonResult = $result->getContent();
            $responseData['result'] = json_decode($jsonResult);
        }

        $response->setData($responseData);
    }
}
