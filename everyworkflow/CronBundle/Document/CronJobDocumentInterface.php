<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CronBundle\Document;

use EveryWorkflow\MongoBundle\Document\BaseDocumentInterface;
use EveryWorkflow\MongoBundle\Document\HelperTrait\CreatedUpdatedHelperTraitInterface;

interface CronJobDocumentInterface extends BaseDocumentInterface, CreatedUpdatedHelperTraitInterface
{
    // Something
}
