<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\ScopeBundle\Controller;

use EveryWorkflow\CoreBundle\Annotation\EwRoute;
use EveryWorkflow\ScopeBundle\Form\ScopeFormInterface;
use EveryWorkflow\ScopeBundle\Repository\ScopeRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class GetScopeController extends AbstractController
{
    public function __construct(
        protected ScopeRepositoryInterface $scopeRepository,
        protected ScopeFormInterface $scopeForm
    ) {
    }

    #[EwRoute(
        path: 'scope/{code}',
        name: 'scope.view',
        methods: 'GET',
        permissions: 'scope.view',
        swagger: [
            'parameters' => [
                [
                    'name' => 'code',
                    'in' => 'path',
                    'default' => 'create',
                ],
            ],
        ]
    )]
    public function __invoke(Request $request, string $code = 'default'): JsonResponse
    {
        $data = [];

        if ('default' !== $code) {
            $item = $this->scopeRepository->findByCode($code);
            if ($item) {
                $data['item'] = $item->toArray();
            }
        }

        if ('data-form' === $request->get('for')) {
            $data['data_form'] = $this->scopeForm->toArray();
            foreach ($data['data_form']['fields'] as &$field) {
                if ('parent' === $field['name']) {
                    $skipVals = [];
                    if ('default' !== $code) {
                        $skipVals[] = $code;
                    }
                    $field['options'] = $this->cleanUpViewingScope($field['options'], $skipVals);
                }
            }
        }

        return new JsonResponse($data);
    }

    protected function cleanUpViewingScope(array $options, array $skipVals): array
    {
        foreach ($options as $key => &$option) {
            if (isset($option['value']) && in_array($option['value'], $skipVals, true)) {
                unset($options[$key]);
                continue;
            }

            if (isset($option['children']) && is_array($option['children'])) {
                $options[$key]['children'] = $this->cleanUpViewingScope($option['children'], $skipVals);
            }
        }

        return array_values($options);
    }
}
