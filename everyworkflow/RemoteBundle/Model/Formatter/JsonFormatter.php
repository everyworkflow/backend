<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\RemoteBundle\Model\Formatter;

use GuzzleHttp\Psr7\Response;
use Psr\Log\LoggerInterface;

class JsonFormatter extends ArrayFormatter implements JsonFormatterInterface
{
    public function __construct(
        protected LoggerInterface $ewRemoteErrorLogger
    ) {
    }

    public function handle(mixed $rawResponse): mixed
    {
        if (!$rawResponse instanceof Response) {
            return null;
        }

        if (200 !== $rawResponse->getStatusCode()) {
            throw new \Exception('Remote request failed: '.$rawResponse->getReasonPhrase().'.');
        }

        $remoteContent = $rawResponse->getBody()->getContents();

        $data = [];

        try {
            $data = json_decode($remoteContent, true);
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
        }

        return $data;
    }
}
