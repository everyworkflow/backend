<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\SwaggerBundle\Model;

use EveryWorkflow\SwaggerBundle\Model\Swagger\ComponentGeneratorInterface;
use EveryWorkflow\SwaggerBundle\Model\Swagger\PathGeneratorInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class SwaggerGenerator implements SwaggerGeneratorInterface
{
    public function __construct(
        protected RequestStack $requestStack,
        protected SwaggerConfigProviderInterface $configProvider,
        protected ComponentGeneratorInterface $componentGenerator,
        protected PathGeneratorInterface $pathGenerator,
    ) {
    }

    public function generate(): SwaggerData
    {
        $config = $this->configProvider->get() ?? [];
        $config['openapi'] = '3.0.3';
        if (0 === count($config['servers'] ?? [])) {
            $config['servers'][] = [
                'url' => $this->requestStack->getCurrentRequest()->getSchemeAndHttpHost(),
            ];
        }
        $swaggerData = new SwaggerData($config);

        $swaggerData = $this->componentGenerator->generate($swaggerData);
        $swaggerData = $this->pathGenerator->generate($swaggerData);

        return $swaggerData;
    }
}
