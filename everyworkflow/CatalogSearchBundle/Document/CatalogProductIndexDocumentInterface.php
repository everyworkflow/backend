<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CatalogSearchBundle\Document;

use EveryWorkflow\MongoBundle\Document\BaseDocumentInterface;
use EveryWorkflow\MongoBundle\Document\HelperTrait\CreatedUpdatedHelperTraitInterface;

interface CatalogProductIndexDocumentInterface extends BaseDocumentInterface, CreatedUpdatedHelperTraitInterface
{
    // Something
}
