<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CoreBundle\Model;

interface SystemDateTimeInterface
{
    public function getTimeZone(): string;

    public function getDateFormat(): string;

    public function getTimeFormat(): string;

    public function getDateTimeFormat(): string;

    public function utcNow(string $dateTime = 'now'): \DateTime;

    public function utcNowFormat(string $dateTime = 'now', ?string $format = null): string;

    public function now(string $dateTime = 'now', ?string $timeZone = null): \DateTime;

    public function nowFormat(string $dateTime = 'now', ?string $timeZone = null, ?string $format = null): string;
}
