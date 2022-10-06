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
    protected UrlRewriteRepositoryInterface $urlRewriteRepository;

    public function __construct(
        UrlRewriteRepositoryInterface $urlRewriteRepository
    ) {
        $this->urlRewriteRepository = $urlRewriteRepository;
    }

    public function migrate(): bool
    {
        $this->urlRewriteRepository->getCollection()->createIndex(['url' => 1], ['unique' => true]);
        return self::SUCCESS;
    }

    public function rollback(): bool
    {
        $this->urlRewriteRepository->getCollection()->drop();
        return self::SUCCESS;
    }
}
