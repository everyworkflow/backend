<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataGridBundle\Model;

use EveryWorkflow\CoreBundle\Support\ArrayableInterface;
use Symfony\Component\HttpFoundation\Request;

interface DataGridParameterInterface extends ArrayableInterface
{
    public const KEY_FILTERS = 'filters';
    public const KEY_OPTIONS = 'options';

    public function setRequest(Request $request): self;

    public function getRequest(): ?Request;

    public function getFilters(): array;

    public function setFilters(array $filters): self;

    public function getOptions(): array;

    public function setOptions(array $options): self;

    public function setFromRequest(Request $request): self;
}
