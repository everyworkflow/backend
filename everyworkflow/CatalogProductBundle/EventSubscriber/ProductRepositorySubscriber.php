<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CatalogProductBundle\EventSubscriber;

use EveryWorkflow\CatalogProductBundle\Entity\CatalogProductEntityInterface;
use EveryWorkflow\MongoBundle\Document\HelperTrait\StatusHelperTraitInterface;
use EveryWorkflow\UrlRewriteBundle\Document\UrlRewriteDocumentInterface;
use EveryWorkflow\UrlRewriteBundle\Repository\UrlRewriteRepositoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ProductRepositorySubscriber implements EventSubscriberInterface, ProductRepositorySubscriberInterface
{
    public function __construct(
        protected UrlRewriteRepositoryInterface $urlRewriteRepository
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'catalog_product_entity_save_one_before' => 'processBeforeSave',
        ];
    }

    public function processBeforeSave(CatalogProductEntityInterface $entity): void
    {
        $this->emitToUrlRewrite($entity);
    }

    protected function emitToUrlRewrite(CatalogProductEntityInterface $entity): void
    {
        if ($entity->getData('url_key') && '' !== $entity->getData('url_key')) {
            $urlRewrite = $this->urlRewriteRepository->create([
                UrlRewriteDocumentInterface::KEY_URL => $entity->getData('url_key'),
                UrlRewriteDocumentInterface::KEY_TYPE_KEY => $entity->getData('url_key'),
                UrlRewriteDocumentInterface::KEY_TYPE => 'catalog_product',
                StatusHelperTraitInterface::KEY_STATUS => StatusHelperTraitInterface::STATUS_ENABLE,
            ]);
            $urlRewriteKeys = [
                'meta_title' => 'meta_title',
                'meta_description' => 'meta_description',
                'meta_keyword' => 'meta_keyword',
            ];
            foreach ($urlRewriteKeys as $toKey => $fromKey) {
                if ($entity->getData($fromKey)) {
                    $urlRewrite->setData($toKey, $entity->getData($fromKey));
                }
            }
            $this->urlRewriteRepository->saveOne($urlRewrite);
        }
    }
}
