<?php
/**
 * @copyright EveryWorkflow. All rights reserved.
 */

namespace EveryWorkflow\CoreBundle\Helper\Trait;

trait GenerateSetMethodNameTrait
{
    protected function generateSetMethodName(string $name): string
    {
        return 'set' . implode(
                '',
                array_map(
                    static fn($item) => ucfirst($item),
                    explode('_', $name)
                )
            );
    }
}
