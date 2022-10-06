<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\SwaggerBundle\Model;

interface SwaggerGeneratorInterface
{
    public function generate(): SwaggerData;
}
