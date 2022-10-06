<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

namespace EveryWorkflow\CoreBundle\EventListener;

use EveryWorkflow\CoreBundle\Exception\ValidatorException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;

class KernelExceptionListener
{
    public function onKernelException(ExceptionEvent $event)
    {
        if (in_array('application/json', $event->getRequest()?->getAcceptableContentTypes() ?? [])) {
            $this->throwForApi($event);
        }
    }

    protected function throwForApi(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();

        if ($exception instanceof ValidatorException) {
            $validator = $exception->getValidator();
            if ($validator) {
                $event->setResponse(new JsonResponse([
                    'title' => 'An error occurred',
                    'status' => Response::HTTP_BAD_REQUEST,
                    'detail' => $exception->getMessage(),
                    'errors' => $validator->getAllErrors(),
                ], Response::HTTP_BAD_REQUEST));
            } else {
                $event->setResponse(new JsonResponse([
                    'title' => 'An error occurred',
                    'status' => Response::HTTP_BAD_REQUEST,
                    'detail' => $exception->getMessage(),
                    'errors' => [],
                ], Response::HTTP_BAD_REQUEST));
            }
        } else if ($exception instanceof HttpException) {
            $event->setResponse(new JsonResponse([
                'title' => 'An error occurred',
                'status' => $exception->getStatusCode(),
                'detail' => $exception->getMessage(),
            ], $exception->getStatusCode()));
        } else {
            $event->setResponse(new JsonResponse([
                'title' => 'An error occurred',
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'detail' => $exception->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR));
        }
    }
}
