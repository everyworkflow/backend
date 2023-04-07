<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\SwaggerBundle\Controller;

use EveryWorkflow\CoreBundle\Annotation\EwRoute;
use EveryWorkflow\SwaggerBundle\Model\SwaggerGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class SwaggerV3JsonController extends AbstractController
{
    public function __construct(
        protected SwaggerGeneratorInterface $swaggerGenerator
    ) {
    }

    #[EwRoute(path: 'swagger/v3.json', name: 'swagger.v3.json', methods: 'GET')]
    public function __invoke(): JsonResponse
    {
        if ('prod' === $this->getParameter('kernel.environment')) {
            throw $this->createNotFoundException('Only available in dev environment');
        }
        $swaggerData = $this->swaggerGenerator->generate();

        return new JsonResponse($swaggerData->toArray());
    }
}
