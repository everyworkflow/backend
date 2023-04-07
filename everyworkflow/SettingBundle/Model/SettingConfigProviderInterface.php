<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\SettingBundle\Model;

use EveryWorkflow\CoreBundle\Model\BaseConfigProviderInterface;

interface SettingConfigProviderInterface extends BaseConfigProviderInterface
{
    public function getMenu(?string $code = null): mixed;
}
