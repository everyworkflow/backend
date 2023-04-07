<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CoreBundle\Factory;

use EveryWorkflow\CoreBundle\Validation\Configuration;
use EveryWorkflow\CoreBundle\Validation\ConfigurationInterface;
use EveryWorkflow\CoreBundle\Validation\ErrorBag;
use EveryWorkflow\CoreBundle\Validation\Validator;
use EveryWorkflow\CoreBundle\Validation\ValidatorInterface;
use EveryWorkflow\CoreBundle\Validation\ValidDataBag;

class ValidatorFactory implements ValidatorFactoryInterface
{
    public function __construct(
        protected ValidationTypeFactoryInterface $validationTypeFactory,
    ) {
    }

    public function create(
        array $rules = [],
        ?ConfigurationInterface $configuration = null
    ): ValidatorInterface {
        if (null === $configuration) {
            $errorBag = $errorBag ?? new ErrorBag();
            $validDataBag = $validDataBag ?? new ValidDataBag();
            $configuration = new Configuration($errorBag, $validDataBag, $rules);
        }

        return new Validator(
            $this->validationTypeFactory,
            $configuration
        );
    }
}
