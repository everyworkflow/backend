<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Document;

use EveryWorkflow\CoreBundle\Validation\Type\StringValidation;
use EveryWorkflow\MongoBundle\Document\BaseDocument;
use EveryWorkflow\MongoBundle\Document\HelperTrait\CreatedUpdatedHelperTrait;
use EveryWorkflow\MongoBundle\Document\HelperTrait\StatusHelperTrait;

class EntityDocument extends BaseDocument implements EntityDocumentInterface
{
    use CreatedUpdatedHelperTrait;
    use StatusHelperTrait;

    #[StringValidation(required: true, minLength: 3, maxLength: 50)]
    public function setCode(string $code): self
    {
        $this->dataObject->setData(self::KEY_CODE, $code);

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->dataObject->getData(self::KEY_CODE);
    }

    #[StringValidation(required: true)]
    public function setClass(string $class): self
    {
        $this->dataObject->setData(self::KEY_CLASS, $class);

        return $this;
    }

    public function getClass(): ?string
    {
        return $this->dataObject->getData(self::KEY_CLASS);
    }

    #[StringValidation(required: true)]
    public function setName(string $name): self
    {
        $this->dataObject->setData(self::KEY_NAME, $name);

        return $this;
    }

    public function getName(): ?string
    {
        return $this->dataObject->getData(self::KEY_NAME);
    }
}
