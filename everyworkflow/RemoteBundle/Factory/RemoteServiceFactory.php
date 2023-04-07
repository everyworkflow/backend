<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\RemoteBundle\Factory;

use EveryWorkflow\RemoteBundle\Model\Client\RemoteClientInterface;
use EveryWorkflow\RemoteBundle\Model\RemoteRequest;
use EveryWorkflow\RemoteBundle\Model\RemoteResponse;
use EveryWorkflow\RemoteBundle\Model\RemoteService;
use EveryWorkflow\RemoteBundle\Model\RemoteServiceInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class RemoteServiceFactory implements RemoteServiceFactoryInterface
{
    public function __construct(
        protected ContainerInterface $container,
        protected RemoteClientInterface $client,
        protected string $requestClassName = RemoteRequest::class,
        protected string $responseHandlerClassName = RemoteResponse::class
    ) {
    }

    public function create(): RemoteServiceInterface
    {
        return new RemoteService(
            $this->client,
            $this->container->get($this->requestClassName),
            $this->container->get($this->responseHandlerClassName)
        );
    }
}
