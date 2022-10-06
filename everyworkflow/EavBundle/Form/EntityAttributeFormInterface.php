<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Form;

use EveryWorkflow\DataFormBundle\Model\FormInterface;
use EveryWorkflow\EavBundle\Repository\BaseEntityRepositoryInterface;

interface EntityAttributeFormInterface extends FormInterface
{
    public function loadAttributeFields(BaseEntityRepositoryInterface $baseEntityRepository): self;
}
