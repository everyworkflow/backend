<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\UserBundle\Migration;

use EveryWorkflow\EavBundle\Document\EntityDocument;
use EveryWorkflow\EavBundle\Repository\AttributeRepositoryInterface;
use EveryWorkflow\EavBundle\Repository\EntityRepositoryInterface;
use EveryWorkflow\MongoBundle\Support\MigrationInterface;
use EveryWorkflow\UserBundle\Entity\UserEntity;
use EveryWorkflow\UserBundle\Repository\UserRepositoryInterface;

class Mongo_2021_01_01_02_00_00_User_Entity_Migration implements MigrationInterface
{
    public function __construct(
        protected EntityRepositoryInterface $entityRepository,
        protected AttributeRepositoryInterface $attributeRepository,
        protected UserRepositoryInterface $userRepository
    ) {
    }

    public function migrate(): bool
    {
        /** @var EntityDocument $entity */
        $entity = $this->entityRepository->create();
        $entity
            ->setName('User')
            ->setCode($this->userRepository->getEntityCode())
            ->setClass(UserEntity::class)
            ->setStatus(EntityDocument::STATUS_ENABLE);
        $entity->setData('flags', ['can_delete' => false, 'can_update' => false]);
        $this->entityRepository->saveOne($entity);

        $attributeData = [
            [
                'code' => 'first_name',
                'name' => 'First name',
                'entity_code' => $this->userRepository->getEntityCode(),
                'type' => 'text_attribute',
                'is_used_in_grid' => true,
                'is_used_in_form' => true,
                'is_required' => true,
                'sort_order' => 10,
                'flags' => ['can_delete' => false],
            ],
            [
                'code' => 'last_name',
                'name' => 'Last name',
                'entity_code' => $this->userRepository->getEntityCode(),
                'type' => 'text_attribute',
                'is_used_in_grid' => true,
                'is_used_in_form' => true,
                'is_required' => false,
                'sort_order' => 12,
                'flags' => ['can_delete' => false],
            ],
            [
                'code' => 'email',
                'name' => 'Email',
                'entity_code' => $this->userRepository->getEntityCode(),
                'type' => 'text_attribute',
                'is_used_in_grid' => true,
                'is_used_in_form' => true,
                'is_required' => true,
                'sort_order' => 30,
                'flags' => ['can_delete' => false],
            ],
            [
                'code' => 'dob',
                'name' => 'Date of birth',
                'entity_code' => $this->userRepository->getEntityCode(),
                'type' => 'date_attribute',
                'is_used_in_form' => true,
                'is_required' => false,
                'sort_order' => 50,
            ],
            [
                'code' => 'phone',
                'name' => 'Phone',
                'entity_code' => $this->userRepository->getEntityCode(),
                'type' => 'text_attribute',
                'is_used_in_form' => true,
                'is_required' => false,
                'sort_order' => 80,
            ],
            [
                'code' => 'profile_image',
                'name' => 'Profile image',
                'entity_code' => $this->userRepository->getEntityCode(),
                'type' => 'text_attribute',
                'is_used_in_grid' => true,
                'is_used_in_form' => true,
                'is_required' => false,
                'sort_order' => 200,
            ],
        ];

        foreach ($attributeData as $item) {
            $item['status'] = 'enable';
            $attribute = $this->attributeRepository->create($item);
            $this->attributeRepository->saveOne($attribute);
        }

        return self::SUCCESS;
    }

    public function rollback(): bool
    {
        $this->attributeRepository->deleteByFilter(['entity_code' => $this->userRepository->getEntityCode()]);
        $this->entityRepository->deleteByCode($this->userRepository->getEntityCode());
        $this->userRepository->getCollection()->drop();

        return self::SUCCESS;
    }
}
