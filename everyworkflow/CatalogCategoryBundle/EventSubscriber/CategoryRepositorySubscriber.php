<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CatalogCategoryBundle\EventSubscriber;

use EveryWorkflow\CatalogCategoryBundle\Entity\CatalogCategoryEntityInterface;
use EveryWorkflow\MongoBundle\Document\HelperTrait\StatusHelperTraitInterface;
use EveryWorkflow\UrlRewriteBundle\Document\UrlRewriteDocumentInterface;
use EveryWorkflow\UrlRewriteBundle\Repository\UrlRewriteRepositoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CategoryRepositorySubscriber implements EventSubscriberInterface, CategoryRepositorySubscriberInterface
{
    public function __construct(
        protected UrlRewriteRepositoryInterface $urlRewriteRepository
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'catalog_category_entity_save_one_before' => 'processBeforeSave',
        ];
    }

    public function processBeforeSave(CatalogCategoryEntityInterface $entity): void
    {
        $this->emitToUrlRewrite($entity);
    }

    protected function emitToUrlRewrite(CatalogCategoryEntityInterface $entity): void
    {
        if ($entity->getData('path') && '' !== $entity->getData('path')) {
            $urlRewrite = $this->urlRewriteRepository->create([
                UrlRewriteDocumentInterface::KEY_URL => $entity->getData('path'),
                UrlRewriteDocumentInterface::KEY_TYPE_KEY => $entity->getData('path'),
                UrlRewriteDocumentInterface::KEY_TYPE => 'catalog_category',
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
