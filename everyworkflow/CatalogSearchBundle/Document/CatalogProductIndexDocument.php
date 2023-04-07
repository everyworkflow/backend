<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CatalogSearchBundle\Document;

use EveryWorkflow\MongoBundle\Document\BaseDocument;
use EveryWorkflow\MongoBundle\Document\HelperTrait\CreatedUpdatedHelperTrait;

class CatalogProductIndexDocument extends BaseDocument implements CatalogProductIndexDocumentInterface
{
    use CreatedUpdatedHelperTrait;
}
