<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\SettingBundle\Helper;

use EveryWorkflow\SettingBundle\Document\SettingDocumentInterface;

interface SettingHelperInterface
{
    public function getSetting(string $code): SettingDocumentInterface;

    public function getSettingValue(string $code, string $key): mixed;

    public function getGeneralValue(string $key): mixed;

    public function getWebValue(string $key): mixed;

    public function getEnvValue(string $key): mixed;
}
