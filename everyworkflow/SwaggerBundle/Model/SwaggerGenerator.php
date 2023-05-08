<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\SwaggerBundle\Model;

use EveryWorkflow\CoreBundle\Annotation\EwRoute;
use EveryWorkflow\EavBundle\Repository\AttributeGroupRepositoryInterface;
use EveryWorkflow\EavBundle\Repository\AttributeRepositoryInterface;
use EveryWorkflow\EavBundle\Repository\EntityRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;

class SwaggerGenerator implements SwaggerGeneratorInterface
{
    public function __construct(
        protected Router $router,
        protected RequestStack $requestStack,
        protected SwaggerConfigProviderInterface $configProvider,
        protected EntityRepositoryInterface $entityRepository,
        protected AttributeRepositoryInterface $attributeRepository,
        protected AttributeGroupRepositoryInterface $attributeGroupRepository
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
                        if (isset($attrArgs['methods']) && is_string($attrArgs['methods']) && 'post' === strtolower($attrArgs['methods'])) {
                            $swaggerData['responses'][400] = [
                                'description' => 'Bad Request',
                                'content' => [
                                    'application/json' => [
                                        'schema' => [
                                            '$ref' => '#/components/schemas/api_bad_request_response',
                                        ],
                                    ],
                                ],
                            ];
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
                                                '$ref' => '#/components/schemas/api_forbidden_response',
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
                                    'description' => 'Json Response',
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
                        $swaggerData['responses'][500] = [
                            'description' => 'Internal Server Error',
                            'content' => [
                                'application/json' => [
                                    'schema' => [
                                        '$ref' => '#/components/schemas/api_internal_server_error_response',
                                    ],
                                ],
                            ],
                        ];

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

        $components['schemas']['api_response'] = [
            'type' => 'object',
            'properties' => [],
        ];

        $components['schemas']['api_internal_server_error_response'] = [
            'type' => 'object',
            'properties' => [
                'title' => [
                    'default' => 'An error occurred',
                    'type' => 'string',
                ],
                'status' => [
                    'default' => 500,
                    'type' => 'number',
                ],
                'detail' => [
                    'default' => 'This is error message.',
                    'type' => 'string',
                ],
            ],
        ];

        $components['schemas']['api_bad_request_response'] = [
            'type' => 'object',
            'properties' => [
                'title' => [
                    'default' => 'An error occurred',
                    'type' => 'string',
                ],
                'status' => [
                    'default' => 400,
                    'type' => 'number',
                ],
                'detail' => [
                    'default' => 'Document data is not valid.',
                    'type' => 'string',
                ],
                'errors' => [
                    'type' => 'object',
                    'properties' => [
                        'field_key_1' => [
                            'type' => 'object',
                            'properties' => [
                                'errors' => [
                                    'type' => 'array',
                                    'items' => [
                                        'default' => 'The field_key_1 is required.',
                                        'type' => 'string',
                                    ],
                                ],
                            ],
                        ],
                        'field_key_2' => [
                            'type' => 'object',
                            'properties' => [
                                'errors' => [
                                    'type' => 'array',
                                    'items' => [
                                        'default' => 'The field_key_2 is required.',
                                        'type' => 'string',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $components['schemas']['api_forbidden_response'] = [
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

        $components['schemas']['data_collection_meta'] = [
            'type' => 'object',
            'properties' => [
                'per_page' => [
                    'default' => 20,
                    'type' => 'number',
                ],
                'result_count' => [
                    'default' => 20,
                    'type' => 'number',
                ],
                'total_count' => [
                    'default' => 20,
                    'type' => 'number',
                ],
                'last_page' => [
                    'default' => 1,
                    'type' => 'number',
                ],
                'current_page' => [
                    'default' => 1,
                    'type' => 'number',
                ],
                'from' => [
                    'default' => 0,
                    'type' => 'number',
                ],
                'to' => [
                    'default' => 20,
                    'type' => 'number',
                ],
            ],
        ];

        $entities = $this->entityRepository->find();

        $attributeList = [];
        $attributes = $this->attributeRepository->find();
        foreach ($attributes as $attribute) {
            $attributeList[$attribute->getData('entity_code')][$attribute->getData('code')] = $attribute;
        }

        $attributeGroupList = [];
        $attributeGroups = $this->attributeGroupRepository->find();
        foreach ($attributeGroups as $attributeGroup) {
            $attributeGroupList[$attributeGroup->getData('entity_code')][$attributeGroup->getData('code')] = $attributeGroup;
        }

        foreach ($entities as $entity) {
            $entityCode = $entity->getData('code') ?? null;
            if ($entityCode && $attributeList[$entityCode]) {
                if (isset($attributeGroupList[$entityCode]) && is_array($attributeGroupList[$entityCode])) {
                    $parentModelData = [
                        'type' => 'object',
                        'oneOf' => [],
                    ];
                    foreach ($attributeGroupList[$entityCode] as $attributeGroup) {
                        $modelData = [
                            'type' => 'object',
                            'oneOf' => [],
                            'properties' => [],
                        ];
                        $attributeGroupData = $attributeGroup->getData('attribute_group_data') ?? [];
                        foreach ($attributeGroupData as $attributeGroupDataItem) {
                            if (isset($attributeGroupDataItem['attributes']) && is_array($attributeGroupDataItem['attributes'])) {
                                foreach ($attributeGroupDataItem['attributes'] as $attributeCode) {
                                    if (isset($attributeList[$entityCode][$attributeCode])) {
                                        $attribute = $attributeList[$entityCode][$attributeCode];
                                        $attributeDefaultVal = $attribute->getData('default_value') ?? '';
                                        $modelData['properties'][$attributeCode] = [
                                            'default' => $attributeDefaultVal,
                                            'type' => 'string',
                                        ];
                                    }
                                }
                            }
                        }
                        $components['schemas'][$entityCode.'_'.$attributeGroup->getData('code')] = $modelData;
                        $parentModelData['oneOf'][] = [
                            'type' => 'object',
                            '$ref' => '#/components/schemas/'.$entityCode.'_'.$attributeGroup->getData('code'),
                        ];
                    }
                    $components['schemas'][$entityCode] = $parentModelData;
                } else {
                    $modelData = [
                        'type' => 'object',
                        'properties' => [],
                    ];
                    foreach ($attributeList[$entityCode] as $attribute) {
                        $modelData['properties'][$attribute->getData('code')] = [
                            'default' => $attribute->getData('default_value') ?? '',
                            'type' => 'string',
                        ];
                    }
                    $components['schemas'][$entityCode] = $modelData;
                }
            }
        }

        ksort($components['schemas']);
        $swaggerData->setComponents($components);

        return $swaggerData;
    }
}
