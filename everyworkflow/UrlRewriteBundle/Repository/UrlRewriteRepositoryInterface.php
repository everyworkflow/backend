<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\UrlRewriteBundle\Repository;

use EveryWorkflow\MongoBundle\Repository\BaseDocumentRepositoryInterface;
use EveryWorkflow\UrlRewriteBundle\Document\UrlRewriteDocumentInterface;

interface UrlRewriteRepositoryInterface extends BaseDocumentRepositoryInterface
{
    /**
     * @return array|object|null
     */
    public function deleteByUrl(string $url, array $otherFilter = []);

    /**
     * @return UrlRewriteDocumentInterface[] 
     */
    public function find(array $filter = [], array $options = []): array;

    public function findOne(array $filter = [], array $options = []): UrlRewriteDocumentInterface;
}
