<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\ScopeBundle\Migration;

use EveryWorkflow\MongoBundle\Support\MigrationInterface;
use EveryWorkflow\ScopeBundle\Document\ScopeDocumentInterface;
use EveryWorkflow\ScopeBundle\Repository\ScopeRepositoryInterface;

class Mongo_2021_01_01_04_00_00_Scope_Data_Migration implements MigrationInterface
{
    public function __construct(
        protected ScopeRepositoryInterface $scopeRepository
    ) {
    }

    public function migrate(): bool
    {
        $indexKeys = [];
        foreach ($this->scopeRepository->getIndexKeys() as $key) {
            $indexKeys[$key] = 1;
        }
        $this->scopeRepository->getCollection()->createIndex($indexKeys, ['unique' => true]);

        $items = [
            [
                'name' => 'Default',
                'code' => ScopeDocumentInterface::DEFAULT_CODE,
                'parent' => '--',
                'status' => 'enable',
            ],
            [
                'name' => 'Admin',
                'code' => ScopeDocumentInterface::ADMIN_SCOPE_CODE,
                'parent' => 'default',
                'status' => 'enable',
            ],
            [
                'name' => 'Frontend',
                'code' => ScopeDocumentInterface::FRONTEND_SCOPE_CODE,
                'parent' => 'default',
                'status' => 'enable',
            ],

            [
                'name' => 'Nepal',
                'code' => 'np',
                'parent' => 'frontend',
                'status' => 'enable',
            ],
            [
                'name' => 'English',
                'code' => 'np_en',
                'parent' => 'np',
                'status' => 'enable',
            ],
            [
                'name' => 'Nepali',
                'code' => 'np_np',
                'parent' => 'np',
                'status' => 'enable',
            ],

            [
                'name' => 'India',
                'code' => 'in',
                'parent' => 'frontend',
                'status' => 'enable',
            ],
            [
                'name' => 'English',
                'code' => 'in_en',
                'parent' => 'in',
                'status' => 'enable',
            ],
            [
                'name' => 'Hindi',
                'code' => 'in_hi',
                'parent' => 'in',
                'status' => 'enable',
            ],
        ];
        $i = 0;
        foreach ($items as $scope) {
            $scope['sort_order'] = $i++;
            $this->scopeRepository->saveOne($this->scopeRepository->create($scope));
        }

        return self::SUCCESS;
    }

    public function rollback(): bool
    {
        $this->scopeRepository->getCollection()->drop();

        return self::SUCCESS;
    }
}
