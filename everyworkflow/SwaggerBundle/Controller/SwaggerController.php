<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\SwaggerBundle\Controller;

use EveryWorkflow\CoreBundle\Annotation\EwRoute;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class SwaggerController extends AbstractController
{
    #[EwRoute(path: "swagger", name: 'swagger', priority: 500, methods: 'GET')]
    public function __invoke(): Response
    {
        if ($this->getParameter('kernel.environment') === 'prod') {
            throw $this->createNotFoundException('Only available in dev environment');
        }
        return $this->render('swagger.html.twig');
    }
}
