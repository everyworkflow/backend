<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataGridBundle\Model;

use EveryWorkflow\CoreBundle\Support\ArrayableInterface;

interface DataCollectionInterface extends ArrayableInterface
{
    public const KEY_RESULTS = 'results';
    public const KEY_META = 'meta';

    public const KEY_FROM = 'from';
    public const KEY_TO = 'to';
    public const KEY_PER_PAGE = 'per_page';
    public const KEY_CURRENT_PAGE = 'current_page';
    public const KEY_LAST_PAGE = 'last_page';
    public const KEY_TOTAL_COUNT = 'total_count';
    public const KEY_RESULT_COUNT = 'result_count';

    /**
     * @return ArrayableInterface[]
     */
    public function getResults(): array;

    /**
     * @param ArrayableInterface[] $results
     * @return $this
     */
    public function setResults(array $results): self;

    public function getFrom(): int;

    public function setFrom(int $from): self;

    public function getTo(): int;

    public function setTo(int $to): self;

    public function getPerPage(): int;

    public function setPerPage(int $perPage): self;

    public function getCurrentPage(): int;

    public function setCurrentPage(int $currentPage): self;

    public function getLastPage(): int;

    public function setLastPage(int $lastPage): self;

    public function getTotalCount(): int;

    public function setTotalCount(int $totalCount): self;

    public function getResultCount(): int;

    public function setResultCount(int $resultCount): self;
}
