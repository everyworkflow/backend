<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\UserBundle\Repository;

use EveryWorkflow\EavBundle\Repository\BaseEntityRepository;
use EveryWorkflow\EavBundle\Support\Attribute\EntityRepositoryAttribute;
use EveryWorkflow\UserBundle\Entity\UserEntity;

#[EntityRepositoryAttribute(documentClass: UserEntity::class, primaryKey: 'email', entityCode: 'user')]
class UserRepository extends BaseEntityRepository implements UserRepositoryInterface
{
    // Something
}
