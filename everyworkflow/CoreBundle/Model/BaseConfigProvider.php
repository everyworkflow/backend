<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CoreBundle\Model;

class BaseConfigProvider implements BaseConfigProviderInterface
{
    protected array $configs = [];

    /**
     * @param array<int,mixed> $configs
     */
    public function __construct(array $configs = [])
    {
        $this->configs = $configs;
    }

    public function get(?string $code = null): mixed
    {
        $value = null;
        if (null === $code) {
            $value = $this->configs;
        } elseif (is_string($code)) {
            $indexes = explode('.', $code);
            foreach ($indexes as $index) {
                if (null === $value && isset($this->configs[$index])) {
                    $value = $this->configs[$index];
                } elseif (isset($value[$index])) {
                    $value = $value[$index];
                } else {
                    $value = null;
                    break;
                }
            }
        }

        return $value;
    }
}
