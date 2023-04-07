<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\TypesenseBundle\Model;

use Typesense\Client;

class TypesenseConnection implements TypesenseConnectionInterface
{
    protected ?Client $client;

    public function __construct(
        protected $apiKey,
        protected $nodes
    ) {
    }
}
