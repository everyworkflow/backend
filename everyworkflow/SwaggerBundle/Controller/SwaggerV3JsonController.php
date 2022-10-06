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
    protected SwaggerGeneratorInterface $swaggerGenerator;

    public function __construct(
        SwaggerGeneratorInterface $swaggerGenerator
    ) {
        $this->swaggerGenerator = $swaggerGenerator;
    }

    #[EwRoute(path: "swagger/v3.json", name: 'swagger.v3.json', methods: 'GET')]
    public function __invoke(): JsonResponse
    {
        if ($this->getParameter('kernel.environment') === 'prod') {
            throw $this->createNotFoundException('Only available in dev environment');
        }
        $swaggerData = $this->swaggerGenerator->generate();
        return new JsonResponse($swaggerData->toArray());
    }
}
