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
    protected ValidationTypeFactoryInterface $validationTypeFactory;

    public function __construct(
        ValidationTypeFactoryInterface $validationTypeFactory,
    ) {
        $this->validationTypeFactory = $validationTypeFactory;
    }

    public function create(
        array $rules = [],
        ?ConfigurationInterface $configuration = null
    ): ValidatorInterface {
        if ($configuration === null) {
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
