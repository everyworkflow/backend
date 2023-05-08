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
        $servers = [];
        if (isset($config['servers']) && is_array($config['servers'])) {
            foreach ($config['servers'] as $server) {
                $servers[] = [
                    'url' => $server,
                ];
            }
        }
        if (0 === count($servers)) {
            $servers[] = [
                'url' => $this->requestStack->getCurrentRequest()->getSchemeAndHttpHost(),
            ];
        }
        $config['servers'] = $servers;
        $swaggerData = new SwaggerData([
            'openapi' => '3.0.1',
            'info' => [
                'version' => '0.1',
            ],
            'components' => [
                'securitySchemes' => [
                    'bearerAuth' => [
                        'type' => 'http',
                        'scheme' => 'bearer',
                        'bearerFormat' => 'JWT',
                    ],
                ],
            ],
            ...$config,
        ]);

        $swaggerData = $this->componentGenerator->generate($swaggerData);
        $swaggerData = $this->pathGenerator->generate($swaggerData);

        return $swaggerData;
    }
}
