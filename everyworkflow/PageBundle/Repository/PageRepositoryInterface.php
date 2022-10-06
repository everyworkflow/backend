<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\PageBundle\Repository;

use EveryWorkflow\EavBundle\Repository\BaseEntityRepositoryInterface;
use EveryWorkflow\PageBundle\Entity\PageEntityInterface;
use MongoDB\UpdateResult;

interface PageRepositoryInterface extends BaseEntityRepositoryInterface
{
    /**
     * @throws \Exception
     */
    public function savePage(
        PageEntityInterface $entity,
        array $otherFilter = [],
        array $otherOptions = []
    ): PageEntityInterface;
}
