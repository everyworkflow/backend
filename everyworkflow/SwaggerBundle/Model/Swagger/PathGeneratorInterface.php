<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\SwaggerBundle\Model\Swagger;

use EveryWorkflow\SwaggerBundle\Model\SwaggerData;

interface PathGeneratorInterface
{
    public function generate(SwaggerData $swaggerData): SwaggerData;
}
