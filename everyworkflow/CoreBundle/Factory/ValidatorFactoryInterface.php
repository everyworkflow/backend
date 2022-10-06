<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CoreBundle\Factory;

use EveryWorkflow\CoreBundle\Validation\ConfigurationInterface;
use EveryWorkflow\CoreBundle\Validation\ValidatorInterface;

interface ValidatorFactoryInterface
{
    public function create(
        array $rules = [],
        ?ConfigurationInterface $configuration = null
    ): ValidatorInterface;
}
