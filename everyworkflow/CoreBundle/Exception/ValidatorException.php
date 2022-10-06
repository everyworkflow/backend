<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

namespace EveryWorkflow\CoreBundle\Exception;

use EveryWorkflow\CoreBundle\Validation\ValidatorInterface;

class ValidatorException extends \Exception
{
    protected ?ValidatorInterface $validator = null;

    public function setValidator(ValidatorInterface $validator): self
    {
        $this->validator = $validator;
        return $this;
    }

    public function getValidator(): ?ValidatorInterface
    {
        return $this->validator;
    }
}
