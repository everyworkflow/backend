<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\UrlRewriteBundle\Document;

use EveryWorkflow\CoreBundle\Validation\Type\StringValidation;
use EveryWorkflow\MongoBundle\Document\BaseDocument;
use EveryWorkflow\MongoBundle\Document\HelperTrait\CreatedUpdatedHelperTrait;
use EveryWorkflow\MongoBundle\Document\HelperTrait\StatusHelperTrait;

class UrlRewriteDocument extends BaseDocument implements UrlRewriteDocumentInterface
{
    use CreatedUpdatedHelperTrait;
    use StatusHelperTrait;

    #[StringValidation(required: true, minLength: 3, maxLength: 50)]
    public function setUrl(string $url): self
    {
        $this->dataObject->setData(self::KEY_URL, $url);

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->dataObject->getData(self::KEY_URL);
    }

    #[StringValidation(required: true)]
    public function setType(string $type): self
    {
        $this->dataObject->setData(self::KEY_TYPE, $type);

        return $this;
    }

    public function getType(): ?string
    {
        return $this->dataObject->getData(self::KEY_TYPE);
    }

    #[StringValidation(required: true)]
    public function setTypeKey(string $typeKey): self
    {
        $this->dataObject->setData(self::KEY_TYPE_KEY, $typeKey);

        return $this;
    }

    public function getTypeKey(): ?string
    {
        return $this->dataObject->getData(self::KEY_TYPE_KEY);
    }
}
