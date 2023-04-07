<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\UrlRewriteBundle\Migration;

use EveryWorkflow\MongoBundle\Support\MigrationInterface;
use EveryWorkflow\UrlRewriteBundle\Repository\UrlRewriteRepositoryInterface;

class Mongo_2021_01_03_03_00_00_Url_Rewrite_Migration implements MigrationInterface
{
    public function __construct(
        protected UrlRewriteRepositoryInterface $urlRewriteRepository
    ) {
    }

    public function migrate(): bool
    {
        return self::SUCCESS;
    }

    public function rollback(): bool
    {
        $this->urlRewriteRepository->getCollection()->drop();

        return self::SUCCESS;
    }
}
