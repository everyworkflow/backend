<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\PageBundle\Repository;

use EveryWorkflow\PageBundle\Entity\PageEntity;
use EveryWorkflow\PageBundle\Entity\PageEntityInterface;
use EveryWorkflow\EavBundle\Repository\BaseEntityRepository;
use EveryWorkflow\EavBundle\Support\Attribute\EntityRepositoryAttribute;
use EveryWorkflow\MongoBundle\Document\HelperTrait\StatusHelperTraitInterface;
use EveryWorkflow\UrlRewriteBundle\Document\UrlRewriteDocumentInterface;
use EveryWorkflow\UrlRewriteBundle\Repository\UrlRewriteRepositoryInterface;
use Symfony\Contracts\Service\Attribute\Required;

#[EntityRepositoryAttribute(
    documentClass: PageEntity::class,
    primaryKey: 'url_path',
    entityCode: 'page'
)]
class PageRepository extends BaseEntityRepository implements PageRepositoryInterface
{
    protected UrlRewriteRepositoryInterface $urlRewriteRepository;

    #[Required]
    public function setUrlRewriteRepository(UrlRewriteRepositoryInterface $urlRewriteRepository): self
    {
        $this->urlRewriteRepository = $urlRewriteRepository;

        return $this;
    }

    /**
     * @throws \Exception
     */
    public function savePage(
        PageEntityInterface $entity,
        array $otherFilter = [],
        array $otherOptions = []
    ): PageEntityInterface {
        $urlPath = $entity->getData('url_path');
        if ($urlPath) {
            $urlRewrite = $this->urlRewriteRepository->create([
                UrlRewriteDocumentInterface::KEY_URL => $entity->getData('url_path'),
                UrlRewriteDocumentInterface::KEY_TYPE => $this->getEntityCode(),
                UrlRewriteDocumentInterface::KEY_TYPE_KEY => $entity->getData('url_path'),
                StatusHelperTraitInterface::KEY_STATUS => StatusHelperTraitInterface::STATUS_ENABLE,
            ]);
            if ($entity->getData('meta_title')) {
                $urlRewrite->setData('meta_title', $entity->getData('meta_title'));
            }
            if ($entity->getData('meta_description')) {
                $urlRewrite->setData('meta_description', $entity->getData('meta_description'));
            }
            if ($entity->getData('meta_keyword')) {
                $urlRewrite->setData('meta_keyword', $entity->getData('meta_keyword'));
            }
            $this->urlRewriteRepository->saveOne($urlRewrite);
        }
        return $this->saveOne($entity, $otherFilter, $otherOptions);
    }
}
