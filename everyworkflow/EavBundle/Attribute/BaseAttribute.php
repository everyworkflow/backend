<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Attribute;

use EveryWorkflow\CoreBundle\Model\DataObjectInterface;
use EveryWorkflow\EavBundle\Document\AttributeDocument;

class BaseAttribute extends AttributeDocument implements BaseAttributeInterface
{
    /**
     * Attribute type must be defined.
     */
    protected string $attributeType = 'base_type';

    public function __construct(DataObjectInterface $dataObject)
    {
        parent::__construct($dataObject);
        $this->dataObject->setDataIfNot(self::KEY_IS_REQUIRED, false);
        $this->dataObject->setDataIfNot(self::KEY_IS_READONLY, false);
        $this->dataObject->setDataIfNot(self::KEY_STATUS, self::STATUS_ENABLE);
        $this->dataObject->setDataIfNot(self::KEY_SORT_ORDER, 0);
    }
    
    public function resetData(array $data): self
    {
        $this->dataObject->resetData($data);
        return $this;
    }

    public function toArray(): array
    {
        $this->dataObject->setDataIfNot(self::KEY_TYPE, $this->attributeType);
        return parent::toArray();
    }
}
