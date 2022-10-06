<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\DataFormBundle\Section;

class CardSection extends BaseSection implements CardSectionInterface
{
    protected string $sectionType = 'card_section';

    public function setTitle(string $title): self
    {
        $this->dataObject->setData(self::KEY_TITLE, $title);
        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->dataObject->getData(self::KEY_TITLE);
    }

    public function setDescription(string $description): self
    {
        $this->dataObject->setData(self::KEY_DESCRIPTION, $description);
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->dataObject->getData(self::KEY_DESCRIPTION);
    }
}
