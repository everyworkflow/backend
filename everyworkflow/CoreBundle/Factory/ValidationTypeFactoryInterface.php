<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CoreBundle\Factory;

use EveryWorkflow\CoreBundle\Validation\ConfigurationInterface;
use EveryWorkflow\CoreBundle\Validation\Type\AbstractValidation;

interface ValidationTypeFactoryInterface
{
    public function create(
        string $property,
        ?ConfigurationInterface $configuration = null,
        array $data = []
    ): ?AbstractValidation;
    
    public function createFromType(
        string $type,
        string $property,
        ?ConfigurationInterface $configuration = null,
        array $data = []
    ): ?AbstractValidation;

     public function createFromClassName(
        string $className,
        string $property,
        ?ConfigurationInterface $configuration = null,
        array $data = [],
    ): ?AbstractValidation;
}
