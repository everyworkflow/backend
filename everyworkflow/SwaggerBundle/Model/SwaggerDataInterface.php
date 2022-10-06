<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\SwaggerBundle\Model;

use EveryWorkflow\CoreBundle\Model\DataObjectInterface;

interface SwaggerDataInterface extends DataObjectInterface
{
    public const KEY_OPENAPI = 'openapi';
    public const KEY_INFO = 'info';
    public const KEY_SERVERS = 'servers';
    public const KEY_TAGS = 'tags';
    public const KEY_PATHS = 'paths';
    public const KEY_COMPONENTS = 'components';
    public const KEY_EXTERNAL_DOCS = 'externalDocs';
}
