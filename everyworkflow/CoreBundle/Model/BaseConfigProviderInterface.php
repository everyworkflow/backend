<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CoreBundle\Model;

interface BaseConfigProviderInterface
{
    /**
     * @param string|null $code
     * @return mixed
     */
    public function get(?string $code = null): mixed;
}
