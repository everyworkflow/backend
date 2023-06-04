<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\UrlRewriteBundle\Repository;

use EveryWorkflow\MongoBundle\Repository\BaseDocumentRepositoryInterface;

interface UrlRewriteRepositoryInterface extends BaseDocumentRepositoryInterface
{
    /**
     * @return array|object|null
     */
    public function deleteByUrl(string $url, array $otherFilter = []);
}
