<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataGridBundle\Model\Collection;

use EveryWorkflow\DataFormBundle\Model\FormInterface;
use EveryWorkflow\DataGridBundle\Model\DataGridConfigInterface;
use EveryWorkflow\DataGridBundle\Model\DataGridParameterInterface;
use EveryWorkflow\MongoBundle\Repository\BaseRepositoryInterface;

interface RepositorySourceInterface extends ArraySourceInterface
{
    public function getRepository(): ?BaseRepositoryInterface;

    public function setRepository(BaseRepositoryInterface $baseRepository): self;

    public function getConfig(): DataGridConfigInterface;

    public function setConfig(DataGridConfigInterface $dataGridConfig): self;

    public function getParameter(): DataGridParameterInterface;

    public function setParameter(DataGridParameterInterface $dataGridParameter): self;

    public function getForm(): FormInterface;

    public function setForm(FormInterface $form): self;
}
