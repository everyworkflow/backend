<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CoreBundle\Validation;

use EveryWorkflow\CoreBundle\Model\DataObjectInterface;

interface ValidDataBagInterface extends DataObjectInterface
{
    public function clear(): self;
}
