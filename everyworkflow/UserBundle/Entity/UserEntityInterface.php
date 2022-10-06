<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\UserBundle\Entity;

use EveryWorkflow\EavBundle\Entity\BaseEntityInterface;

interface UserEntityInterface extends BaseEntityInterface
{
    public const KEY_PASSWORD = 'password';
    public const KEY_EMAIL = 'email';
    public const KEY_FIRST_NAME = 'first_name';
    public const KEY_LAST_NAME = 'last_name';
    public const KEY_PPROFILE_IMAGE = 'profile_image';
    public const KEY_DOB = 'dob';

    public function setEmail($email);

    public function getEmail();

    public function setFirstName($firstName);

    public function getFirstName();

    public function setLastName($lastName);

    public function getLastName();

    public function setDob($dob);

    public function getDob();
}
