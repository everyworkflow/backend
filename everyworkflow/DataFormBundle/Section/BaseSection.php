<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataFormBundle\Section;

use EveryWorkflow\DataFormBundle\Model\Form;

class BaseSection extends Form implements BaseSectionInterface
{
    protected string $sectionType = 'base_section';

    public function getSectionType(): string
    {
        return $this->sectionType;
    }

    public function getCode(): ?string
    {
        return $this->dataObject->getData(self::KEY_CODE);
    }

    public function setCode(string $code): self
    {
        $this->dataObject->setData(self::KEY_CODE, $code);
        return $this;
    }

    public function getSortOrder(): ?int
    {
        return $this->dataObject->getData(self::KEY_SORT_ORDER);
    }

    public function setSortOrder(int $sortOrder): self
    {
        $this->dataObject->setData(self::KEY_SORT_ORDER, $sortOrder);
        return $this;
    }

    public function resetData($data): self
    {
        $this->dataObject->resetData($data);
        return $this;
    }

    public function toArray(): array
    {
        $data = parent::toArray();
        $data['section_type'] = $this->getSectionType();
        return $data;
    }
}
