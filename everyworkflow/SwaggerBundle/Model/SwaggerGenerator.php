<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\SwaggerBundle\Model;

use EveryWorkflow\CoreBundle\Annotation\EwRoute;
use ReflectionClass;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;

class SwaggerGenerator implements SwaggerGeneratorInterface
{
    protected Router $router;
    protected RequestStack $requestStack;
    protected SwaggerConfigProviderInterface $configProvider;

    public function __construct(
        Router $router,
        RequestStack $requestStack,
        SwaggerConfigProviderInterface $configProvider
    ) {
        $this->router = $router;
        $this->requestStack = $requestStack;
        $this->configProvider = $configProvider;
    }

    public function generate(): SwaggerData
    {
        $config = $this->configProvider->get() ?? [];
        $servers = [
            [
                'url' => $this->requestStack->getCurrentRequest()->getSchemeAndHttpHost(),
            ]
        ];
        if (isset($config['servers']) && is_array($config['servers'])) {
            foreach ($config['servers'] as $server) {
                $servers[] = [
                    'url' => $server,
                ];
            }
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
                        'bearerFormat' => 'JWT'
                    ]
                ],
            ],
            ...$config,
        ]);

        $this->addControllerData($swaggerData);

        return $swaggerData;
    }

    protected function addControllerData(SwaggerData $swaggerData): void
    {
        $tags = [];
        $paths = [];

        $routeCollection = $this->router->getRouteCollection();
        foreach ($routeCollection as $routeName => $route) {
            if (str_starts_with($routeName, '_')) {
                continue;
            }

            $routeClassName = $route->getDefault('_controller');
            $routeClassNameArr = explode('::', $routeClassName);
            if (count($routeClassNameArr)) {
                $routeClassName = $routeClassNameArr[0];
            }

            $controllerSwaggerData = $this->getSwaggerDataForController($routeClassName, $routeName);
            if (!$controllerSwaggerData) {
                continue;
            }

            $routeNameArr = explode('.', $routeName);
            $tag = $routeNameArr[0];
            if (!isset($tags[$tag])) {
                $tags[$tag] = [
                    'name' => $tag,
                ];
            }

            $pathData = [
                'operationId' => $routeName,
                'summary' => $routeName,
                'tags' => [$tag],
                'consumes' => [
                    'application/json',
                ],
                'produces' => [
                    'application/json',
                ]
            ];

            if (is_array($controllerSwaggerData)) {
                $pathData = array_merge($pathData, $controllerSwaggerData);
            }

            foreach ($route->getMethods() as $method) {
                $paths[$route->getPath()][strtolower($method)] = $pathData;
            }
        }

        ksort($tags);
        $swaggerData->setTags(array_values($tags));
        ksort($paths);
        $swaggerData->setPaths($paths);
    }

    protected function getSwaggerDataForController(string $controllerClassName, string $routeName): mixed
    {
        $reflectionClass = new ReflectionClass($controllerClassName);
        foreach ($reflectionClass->getMethods() as $method) {

            foreach ($method->getAttributes() as $attribute) {
                if ($attribute->getName() === EwRoute::class) {
                    $attrArgs = $attribute->getArguments();
                    if (isset($attrArgs['name']) && $attrArgs['name'] === $routeName && isset($attrArgs['swagger'])) {
                        $swaggerData = $attrArgs['swagger'];
                        if (!is_array($swaggerData)) {
                            $swaggerData = [];
                        }
                        if (isset($attrArgs['permissions'])) {
                            $swaggerData['security'] = [
                                [
                                    'bearerAuth' => [],
                                ],
                            ];
                            if (
                                !isset($swaggerData['responses']) ||
                                (isset($swaggerData['responses']) && !isset($swaggerData['responses'][403]))
                            ) {
                                $swaggerData['responses'][403] = [
                                    'description' => 'Forbidden',
                                    'content' => [
                                        'application/json' => [
                                            'schema' => [
                                                'type' => 'object',
                                                'properties' => [
                                                    'title' => [
                                                        'default' => 'An error occurred',
                                                        'type' => 'string',
                                                    ],
                                                    'status' => [
                                                        'default' => 403,
                                                        'type' => 'number',
                                                    ],
                                                    'detail' => [
                                                        'default' => 'You do not have permission to access this resource.',
                                                        'type' => 'string',
                                                    ]
                                                ]
                                            ]
                                        ]
                                    ]
                                ];
                            }
                        }
                        if (
                            $method->getReturnType() && (
                                !isset($swaggerData['responses']) ||
                                (isset($swaggerData['responses']) && !isset($swaggerData['responses'][200]))
                            )
                        ) {
                            if ($method->getReturnType()->getName() === JsonResponse::class) {
                                $swaggerData['responses'][200] = [
                                    'description' => 'Json response',
                                    'content' => [
                                        'application/json' => [],
                                    ],
                                ];
                            } else if (!empty($method->getReturnType()->getName())) {
                                $swaggerData['responses'][200] = [
                                    'description' => 'Success',
                                ];
                            }
                        }
                        return $swaggerData;
                        break;
                    }
                }
            }
        }

        return null;
    }
}
