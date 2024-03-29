<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\SettingBundle\Model;

use EveryWorkflow\CoreBundle\Model\BaseConfigProvider;

class SettingConfigProvider extends BaseConfigProvider implements SettingConfigProviderInterface
{
    public function getMenu(?string $code = null): mixed
    {
        $parsedConfig = $this->parseConfig($this->configs);
        $menuData = isset($parsedConfig['menu']) ? $parsedConfig['menu'] : [];

        $value = null;
        if (null === $code) {
            $value = $menuData;
        } elseif (is_string($code)) {
            $indexes = explode('.', $code);
            foreach ($indexes as $index) {
                if (null === $value && isset($menuData[$index])) {
                    $value = $menuData[$index];
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

    /**
     * @param array<int,mixed> $configs
     *
     * @return array<int,mixed>
     */
    protected function parseConfig(array $configs): array
    {
        foreach ($configs as $key => $val) {
            if (is_array($val)) {
                $configs[$key] = $this->parseConfig($val);
            }

            $indexes = explode('.', $key);
            $indexLength = count($indexes);
            if ($indexLength > 1) {
                unset($configs[$key]);
                $finalIndex = array_pop($indexes);
                $menuIndexPointer = &$configs;
                foreach ($indexes as $index) {
                    if (!isset($menuIndexPointer[$index])) {
                        $menuIndexPointer[$index] = [];
                    }
                    $menuIndexPointer = &$menuIndexPointer[$index];
                }
                if (!isset($menuIndexPointer[$finalIndex])) {
                    $menuIndexPointer[$finalIndex] = $val;
                }
            }
        }

        return $configs;
    }
}
