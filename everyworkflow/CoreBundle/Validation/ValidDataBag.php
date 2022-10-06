<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CoreBundle\Validation;

use EveryWorkflow\CoreBundle\Model\DataObject;

class ValidDataBag extends DataObject implements ValidDataBagInterface
{
    public function clear(): self
    {
        $this->data = [];

        return $this;
    }
}
