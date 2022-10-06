<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\UserBundle\Entity;

use EveryWorkflow\CoreBundle\Validation\Type\StringValidation;
use EveryWorkflow\EavBundle\Entity\BaseEntity;
use Symfony\Component\Validator\Constraints\DateTimeValidator;

class UserEntity extends BaseEntity implements UserEntityInterface
{
    #[StringValidation(required: true, minLength: 5, maxLength: 30)]
    public function setEmail($email)
    {
        $this->dataObject->setData(self::KEY_EMAIL, $email);

        return $this;
    }

    public function getEmail()
    {
        return $this->dataObject->getData(self::KEY_EMAIL);
    }

    #[StringValidation(required: true, minLength: 4, maxLength: 20)]
    public function setFirstName($firstName)
    {
        $this->dataObject->setData(self::KEY_FIRST_NAME, $firstName);

        return $this;
    }

    public function getFirstName()
    {
        return $this->dataObject->getData(self::KEY_FIRST_NAME);
    }

    #[StringValidation(required: true, minLength: 4, maxLength: 20)]
    public function setLastName($lastName)
    {
        $this->dataObject->setData(self::KEY_LAST_NAME, $lastName);

        return $this;
    }

    public function getLastName()
    {
        return $this->dataObject->getData(self::KEY_LAST_NAME);
    }

    #[DateTimeValidator(required: true, format: 'Y-m-d')]
    public function setDob($dob)
    {
        $this->dataObject->setData(self::KEY_DOB, $dob);

        return $this;
    }

    public function getDob()
    {
        return $this->dataObject->getData(self::KEY_DOB);
    }

    #[StringValidation()]
    public function setMobile($dob)
    {
        $this->dataObject->setData(self::KEY_DOB, $dob);

        return $this;
    }

    public function getMobile()
    {
        return $this->dataObject->getData(self::KEY_DOB);
    }
}
