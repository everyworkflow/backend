<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CoreBundle\Model;

class SystemDateTime implements SystemDateTimeInterface
{
    public function __construct(
        protected CoreConfigProviderInterface $coreConfigProvider
    ) {
    }

    public function getTimeZone(): string
    {
        return $this->coreConfigProvider->get('date_time.time_zone') ?? 'UTC';
    }

    public function getDateFormat(): string
    {
        return $this->coreConfigProvider->get('date_time.date_format') ?? 'Y-m-d';
    }

    public function getTimeFormat(): string
    {
        return $this->coreConfigProvider->get('date_time.time_format') ?? 'H:i:s';
    }

    public function getDateTimeFormat(): string
    {
        return $this->coreConfigProvider->get('date_time.date_time_format') ?? 'Y-m-d H:i:s';
    }

    public function utcNow(string $dateTime = 'now'): \DateTime
    {
        return new \DateTime($dateTime, new \DateTimeZone('UTC'));
    }

    public function utcNowFormat(string $dateTime = 'now', ?string $format = null): string
    {
        if (null === $format) {
            $format = $this->getDateTimeFormat();
        }

        return $this->utcNow($dateTime)->format($format);
    }

    public function now(string $dateTime = 'now', ?string $timeZone = null): \DateTime
    {
        if (null === $timeZone) {
            $timeZone = $this->getTimeZone();
        }

        return new \DateTime($dateTime, new \DateTimeZone($this->getTimeZone()));
    }

    public function nowFormat(string $dateTime = 'now', ?string $timeZone = null, ?string $format = null): string
    {
        if (null === $format) {
            $format = $this->getDateTimeFormat();
        }

        return $this->now($dateTime, $timeZone)->format($format);
    }
}
