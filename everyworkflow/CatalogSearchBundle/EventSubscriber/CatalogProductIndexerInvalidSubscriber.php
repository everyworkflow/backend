<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CatalogSearchBundle\EventSubscriber;

use EveryWorkflow\CatalogProductBundle\Entity\CatalogProductEntityInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CatalogProductIndexerInvalidSubscriber implements EventSubscriberInterface, CatalogProductIndexerInvalidSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            'catalog_product_entity__save_one_before' => 'processProductBeforeSave',
        ];
    }

    public function processProductBeforeSave(CatalogProductEntityInterface $product): CatalogProductEntityInterface
    {
        $indexerData = $product->getData('indexer');
        $indexerData['index_status']['catalog_product_indexer'] = 'invalid';
        return $product->setData('indexer', $indexerData);
    }
}
