<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Factory;

use EveryWorkflow\DataFormBundle\Factory\FormFieldFactoryInterface;
use EveryWorkflow\DataFormBundle\Field\BaseFieldInterface;
use EveryWorkflow\EavBundle\Attribute\BaseAttributeInterface;

interface AttributeFieldFactoryInterface extends FormFieldFactoryInterface
{
    public function createFromAttribute(BaseAttributeInterface $attribute): BaseFieldInterface;
}
