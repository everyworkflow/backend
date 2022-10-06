<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Model\Collection;

use EveryWorkflow\DataGridBundle\Model\Collection\RepositorySource;
use EveryWorkflow\EavBundle\Repository\BaseEntityRepositoryInterface;
use EveryWorkflow\MongoBundle\Repository\BaseRepositoryInterface;

class EntityRepositorySource extends RepositorySource implements EntityRepositorySourceInterface
{
    protected ?BaseEntityRepositoryInterface $baseEntityRepository = null;

    public function getEntityRepository(): ?BaseEntityRepositoryInterface
    {
        return $this->baseEntityRepository;
    }

    public function setEntityRepository(BaseEntityRepositoryInterface $baseEntityRepository): self
    {
        $this->baseEntityRepository = $baseEntityRepository;
        return $this;
    }

    public function getRepository(): BaseRepositoryInterface
    {
        if ($this->baseEntityRepository) {
            return $this->baseEntityRepository;
        }
        return parent::getRepository();
    }
}
