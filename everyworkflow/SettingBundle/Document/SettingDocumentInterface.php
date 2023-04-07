<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\SettingBundle\Document;

use EveryWorkflow\MongoBundle\Document\BaseDocumentInterface;
use EveryWorkflow\MongoBundle\Document\HelperTrait\CreatedUpdatedHelperTraitInterface;
use EveryWorkflow\MongoBundle\Document\HelperTrait\StatusHelperTraitInterface;

interface SettingDocumentInterface extends BaseDocumentInterface, CreatedUpdatedHelperTraitInterface, StatusHelperTraitInterface
{
    public const KEY_CODE = 'code';
}
