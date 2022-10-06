<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Model\Collection;

use EveryWorkflow\DataGridBundle\Model\Collection\RepositorySourceInterface;
use EveryWorkflow\EavBundle\Repository\BaseEntityRepositoryInterface;

interface EntityRepositorySourceInterface extends RepositorySourceInterface
{
    public function getEntityRepository(): ?BaseEntityRepositoryInterface;

    public function setEntityRepository(BaseEntityRepositoryInterface $baseEntityRepository): self;
}
