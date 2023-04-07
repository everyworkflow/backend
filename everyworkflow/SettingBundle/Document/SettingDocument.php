<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\SettingBundle\Document;

use EveryWorkflow\CoreBundle\Validation\Type\StringValidation;
use EveryWorkflow\MongoBundle\Document\BaseDocument;
use EveryWorkflow\MongoBundle\Document\HelperTrait\CreatedUpdatedHelperTrait;
use EveryWorkflow\MongoBundle\Document\HelperTrait\StatusHelperTrait;

class SettingDocument extends BaseDocument implements SettingDocumentInterface
{
    use CreatedUpdatedHelperTrait;
    use StatusHelperTrait;

    #[StringValidation(required: true, minLength: 2, maxLength: 20)]
    public function setCode(string $code): self
    {
        $this->dataObject->setData(self::KEY_CODE, $code);

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->dataObject->getData(self::KEY_CODE);
    }
}
