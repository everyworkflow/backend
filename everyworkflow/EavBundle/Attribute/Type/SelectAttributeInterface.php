<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Attribute\Type;

use EveryWorkflow\EavBundle\Attribute\BaseAttributeInterface;
use EveryWorkflow\EavBundle\Attribute\Type\Select\OptionInterface;

interface SelectAttributeInterface extends BaseAttributeInterface
{
    /**
     * @param OptionInterface[] | \MongoDB\Model\BSONArray $options
     */
    public function setOptions(array|\MongoDB\Model\BSONArray $options): self;

    /**
     * @return OptionInterface[]
     */
    public function getOptions(): array;
}
