<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\SettingBundle\Helper;

use EveryWorkflow\SettingBundle\Document\SettingDocumentInterface;
use EveryWorkflow\SettingBundle\Repository\SettingDocumentRepository;

class SettingHelper implements SettingHelperInterface
{
    public function __construct(
        protected SettingDocumentRepository $settingDocumentRepository,
    ) {
    }

    public function getSetting(string $code): SettingDocumentInterface
    {
        $code = str_replace('-', '.', $code);
        $code = str_replace('_', '.', $code);

        return $this->settingDocumentRepository->findOne([
            'code' => $code,
        ]);
    }

    public function getSettingValue(string $code, string $key): mixed
    {
        $setting = $this->getSetting($code);

        return $setting->getData($key);
    }

    public function getGeneralValue(string $key): mixed
    {
        return $this->getSettingValue('general.setting', $key);
    }

    public function getWebValue(string $key): mixed
    {
        // TODO: implement different logic for setting code generation
        return $this->getSettingValue('general.web', $key);
    }

    public function getEnvValue(string $key): mixed
    {
        if (isset($_ENV[$key])) {
            return $_ENV[$key];
        }

        return null;
    }
}
