<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Attribute;

use EveryWorkflow\EavBundle\Document\AttributeDocumentInterface;

interface BaseAttributeInterface extends AttributeDocumentInterface
{
    public function resetData(array $data): self;
}
