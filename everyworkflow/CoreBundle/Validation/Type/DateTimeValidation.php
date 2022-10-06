<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CoreBundle\Validation\Type;

use EveryWorkflow\CoreBundle\Model\SystemDateTimeInterface;
use Symfony\Contracts\Service\Attribute\Required;

class DateTimeValidation extends AbstractValidation
{
    public const KEY_FORMAT = 'format';
    public const KEY_MIN_DATE = 'min_date';
    public const KEY_MAX_DATE = 'max_date';

    protected SystemDateTimeInterface $systemDateTime;

    #[Required]
    public function setSystemDateTime(SystemDateTimeInterface $systemDateTime): self
    {
        $this->systemDateTime = $systemDateTime;
        return $this;
    }

    public function setFormat(string $format): self
    {
        $this->setData(self::KEY_FORMAT, $format);
        return $this;
    }

    public function getFormat(): ?string
    {
        return $this->getData(self::KEY_FORMAT);
    }

    public function setMinDate(string $minDate): self
    {
        $this->setData(self::KEY_MIN_DATE, $minDate);
        return $this;
    }

    public function getMinDate(): ?string
    {
        return $this->getData(self::KEY_MIN_DATE);
    }

    public function setMaxDate(string $maxDate): self
    {
        $this->setData(self::KEY_MAX_DATE, $maxDate);
        return $this;
    }

    public function getMaxDate(): ?string
    {
        return $this->getData(self::KEY_MAX_DATE);
    }

    protected function transform(mixed $value): mixed
    {
        $format = $this->getFormat();
        if ($format === null) {
            $format = $this->systemDateTime->getDateTimeFormat();
        }

        $validValue = $this->systemDateTime->utcNowFormat($value, $format);

        return $validValue;
    }

    protected function validateMinMaxDate(string $value): ?bool
    {
        $dateObj = $this->systemDateTime->utcNow($value);

        if (null !== $this->getMinDate()) {
            $minDateObj = $this->systemDateTime->utcNow($this->getMinDate());
            if ($minDateObj > $dateObj) {
                $this->errorBag->addError(
                    $this->getProperty(),
                    sprintf(
                        '%s must be greater than or equal to %s.',
                        $this->getPropertyName(),
                        $this->getMinDate()
                    )
                );

                return false;
            }
        }

        if (null !== $this->getMaxDate()) {
            $maxDateObj = $this->systemDateTime->utcNow($this->getMaxDate());
            if ($maxDateObj < $dateObj) {
                $this->errorBag->addError(
                    $this->getProperty(),
                    sprintf(
                        '%s must be less than or equal to %s.',
                        $this->getPropertyName(),
                        $this->getMaxDate()
                    )
                );

                return false;
            }
        }

        return null;
    }

    protected function _validate(mixed $value): bool
    {
        if (!$this->isRequired() && ($value === null || $value === '')) {
            $this->setValidData($value);
            return true;
        }

        $requiredResult = $this->validateRequired($value);
        if (null !== $requiredResult) {
            return $requiredResult;
        }

        $value = $this->transform($value);

        $minMaxResult = $this->validateMinMaxDate($value);
        if (null !== $minMaxResult) {
            return $minMaxResult;
        }

        $this->setValidData($value);

        return true;
    }
}
