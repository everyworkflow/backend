<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\SwaggerBundle\Model;

use EveryWorkflow\CoreBundle\Annotation\EwRoute;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;

class SwaggerGenerator implements SwaggerGeneratorInterface
{
    public function __construct(
        protected Router $router,
        protected RequestStack $requestStack,
        protected SwaggerConfigProviderInterface $configProvider
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

        $swaggerData = $this->addControllerData($swaggerData);
        $swaggerData = $this->addModelData($swaggerData);

        return $swaggerData;
    }

    protected function addControllerData(SwaggerData $swaggerData): SwaggerData
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

            if (isset($controllerSwaggerData['tags']) && is_array($controllerSwaggerData['tags'])) {
                $currentTags = $controllerSwaggerData['tags'];
                if (is_array($currentTags) && count($currentTags) > 0) {
                    $currentTag = $currentTags[0];
                    $tags[$currentTag] = [
                        'name' => $currentTag,
                    ];
                }
            } else {
                $routeNameArr = explode('.', $routeName);
                $currentTag = $routeNameArr[0];
                if (!isset($tags[$currentTag])) {
                    $tags[$currentTag] = [
                        'name' => $currentTag,
                    ];
                }
                $currentTags = [$currentTag];
            }
            $pathData = [
                'operationId' => $routeName,
                'summary' => $routeName,
                'tags' => $currentTags,
                'consumes' => [
                    'application/json',
                ],
                'produces' => [
                    'application/json',
                ],
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

        return $swaggerData;
    }

    protected function getSwaggerDataForController(string $controllerClassName, string $routeName): mixed
    {
        $reflectionClass = new \ReflectionClass($controllerClassName);
        foreach ($reflectionClass->getMethods() as $method) {
            foreach ($method->getAttributes() as $attribute) {
                if (EwRoute::class === $attribute->getName()) {
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
                            if (isset($attrArgs['methods']) && is_string($attrArgs['methods']) && 'post' === strtolower($attrArgs['methods'])) {
                                $swaggerData['responses'][400] = [
                                    'description' => 'Bad Request',
                                    'content' => [
                                        'application/json' => [
                                            'schema' => [
                                                '$ref' => '#/components/schemas/ApiBadRequestResponse',
                                            ],
                                        ],
                                    ],
                                ];
                            }
                            if (
                                !isset($swaggerData['responses']) ||
                                (isset($swaggerData['responses']) && !isset($swaggerData['responses'][403]))
                            ) {
                                $swaggerData['responses'][403] = [
                                    'description' => 'Forbidden',
                                    'content' => [
                                        'application/json' => [
                                            'schema' => [
                                                '$ref' => '#/components/schemas/ApiForbiddenResponse',
                                            ],
                                        ],
                                    ],
                                ];
                            }
                        }
                        if (
                            $method->getReturnType() && (
                                !isset($swaggerData['responses']) ||
                                (isset($swaggerData['responses']) && !isset($swaggerData['responses'][200]))
                            )
                        ) {
                            if (JsonResponse::class === $method->getReturnType()->getName()) {
                                $swaggerData['responses'][200] = [
                                    'description' => 'Json response',
                                    'content' => [
                                        'application/json' => [],
                                    ],
                                ];
                            } elseif (!empty($method->getReturnType()->getName())) {
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

    protected function addModelData(SwaggerData $swaggerData): SwaggerData
    {
        $components = $swaggerData->getComponents();

        $components['schemas'] = $components['schemas'] ?? [];

        $components['schemas']['ApiResponse'] = [
            'type' => 'object',
            'properties' => [],
        ];

        $components['schemas']['ApiBadRequestResponse'] = [
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
                ],
            ],
        ];

        $components['schemas']['ApiForbiddenResponse'] = [
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
                ],
            ],
        ];

        $swaggerData->setComponents($components);

        return $swaggerData;
    }
}
