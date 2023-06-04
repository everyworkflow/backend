<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\PageBundle\EventSubscriber;

use EveryWorkflow\MongoBundle\Document\HelperTrait\StatusHelperTraitInterface;
use EveryWorkflow\PageBundle\Entity\PageEntityInterface;
use EveryWorkflow\UrlRewriteBundle\Document\UrlRewriteDocumentInterface;
use EveryWorkflow\UrlRewriteBundle\Repository\UrlRewriteRepositoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class PageRepositorySubscriber implements EventSubscriberInterface, PageRepositorySubscriberInterface
{
    public function __construct(
        protected UrlRewriteRepositoryInterface $urlRewriteRepository
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'page_entity_save_one_before' => 'processBeforeSave',
        ];
    }

    public function processBeforeSave(PageEntityInterface $entity): void
    {
        $this->emitToUrlRewrite($entity);
    }

    protected function emitToUrlRewrite(PageEntityInterface $entity): void
    {
        if ($entity->getData('url_path') && '' !== $entity->getData('url_path')) {
            $urlRewrite = $this->urlRewriteRepository->create([
                UrlRewriteDocumentInterface::KEY_URL => $entity->getData('url_path'),
                UrlRewriteDocumentInterface::KEY_TYPE_KEY => $entity->getData('url_path'),
                UrlRewriteDocumentInterface::KEY_TYPE => 'page',
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
