<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CoreBundle\Tests;

use EveryWorkflow\CoreBundle\Factory\ValidationTypeFactory;
use EveryWorkflow\CoreBundle\Factory\ValidatorFactory;
use EveryWorkflow\CoreBundle\Factory\ValidatorFactoryInterface;
use EveryWorkflow\CoreBundle\Model\CoreConfigProvider;
use EveryWorkflow\CoreBundle\Model\CoreConfigProviderInterface;
use EveryWorkflow\CoreBundle\Model\DataObjectFactory;
use EveryWorkflow\CoreBundle\Model\DataObjectFactoryInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BaseTestCase extends KernelTestCase
{
    public function getDataObjectFactory(): DataObjectFactoryInterface
    {
        return new DataObjectFactory();
    }

    public function getCoreConfigProvider(array $configs = []): CoreConfigProviderInterface
    {
        return new CoreConfigProvider([
            'date_time' => [
                'date_time_format' => 'Y-m-d H:i:s',
                'time_zone' => 'Asia/Kathmandu',
            ],
            'validation_types' => [
                'array' => 'EveryWorkflow\CoreBundle\Validation\Type\ArrayValidation',
                'string' => 'EveryWorkflow\CoreBundle\Validation\Type\StringValidation',
                'number' => 'EveryWorkflow\CoreBundle\Validation\Type\NumberValidation',
                'boolean' => 'EveryWorkflow\CoreBundle\Validation\Type\BooleanValidation',
                'date_time' => 'EveryWorkflow\CoreBundle\Validation\Type\DateTimeValidation',
            ],
            ...$configs,
        ]);
    }

    protected function getValidatorFactory(): ValidatorFactoryInterface
    {
        $validationTypeFactory = new ValidationTypeFactory(
            $this->getContainer(),
            $this->getCoreConfigProvider(),
            $this->getDataObjectFactory()
        );
        return new ValidatorFactory($validationTypeFactory);
    }
}
