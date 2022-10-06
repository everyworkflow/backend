<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataGridBundle\Model;

use EveryWorkflow\CoreBundle\Support\ArrayableInterface;
use EveryWorkflow\DataFormBundle\Model\FormInterface;
use EveryWorkflow\DataGridBundle\Model\Collection\ArraySourceInterface;
use Symfony\Component\HttpFoundation\Request;

interface DataGridInterface extends ArrayableInterface
{
    public const KEY_DATA_COLLECTION = 'data_collection';
    public const KEY_DATA_GRID_CONFIG = 'data_grid_config';
    public const KEY_DATA_FORM = 'data_form';

    public function getConfig(): DataGridConfigInterface;

    public function setConfig(DataGridConfigInterface $dataGridConfig): self;

    public function getForm(): FormInterface;

    public function setForm(FormInterface $form): self;

    public function getSource(): ArraySourceInterface;

    public function setSource(ArraySourceInterface $collectionSource): self;

    public function setFromRequest(Request $request): self;

    public function setRequest(Request $request): self;

    public function getRequest(): ?Request;

    public function setFilters(array $filters): self;

    public function getFilters(): array;

    public function setOptions(array $options): self;

    public function getOptions(): array;
}
