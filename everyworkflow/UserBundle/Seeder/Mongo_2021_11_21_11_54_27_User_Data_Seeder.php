<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\UserBundle\Seeder;

use EveryWorkflow\AuthBundle\Security\AuthUser;
use EveryWorkflow\MongoBundle\Support\SeederInterface;
use EveryWorkflow\UserBundle\Repository\UserRepositoryInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class Mongo_2021_11_21_11_54_27_User_Data_Seeder implements SeederInterface
{
    public function __construct(
        protected UserRepositoryInterface $userRepository,
        protected UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function seed(): bool
    {
        $authUser = new AuthUser();

        $this->userRepository->saveOne($this->userRepository->create([
            'username' => 'admin',
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@example.com',
            'password' => $this->passwordHasher->hashPassword($authUser, 'admin@123'),
            'dob' => '2020-01-01',
            'roles' => ['admin', 'user'],
        ]));

        $this->userRepository->saveOne($this->userRepository->create([
            'username' => 'test',
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@example.com',
            'password' => $this->passwordHasher->hashPassword($authUser, 'test@123'),
            'dob' => '2020-01-01',
            'roles' => ['user'],
        ]));

        // for ($i = 0; $i < 100; $i++) {
        //     $this->userRepository->saveOne($this->userRepository->create([
        //         'username' => 'test' . $i,
        //         'first_name' => 'Test-' . $i,
        //         'last_name' => 'User-' . $i,
        //         'email' => 'test' . $i . '@example.com',
        //         'password' => $this->passwordHasher->hashPassword($authUser, 'test@123'),
        //         'dob' => '2020-01-01',
        //         'roles' => ['user'],
        //     ]));
        // }

        return self::SUCCESS;
    }

    public function rollback(): bool
    {
        $this->userRepository->deleteByFilter([
            'email' => 'admin@example.com',
        ]);
        $this->userRepository->deleteByFilter([
            'email' => 'test@example.com',
        ]);

        return self::SUCCESS;
    }
}
