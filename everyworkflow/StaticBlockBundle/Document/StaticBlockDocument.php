<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\StaticBlockBundle\Document;

use EveryWorkflow\MongoBundle\Document\BaseDocument;
use EveryWorkflow\MongoBundle\Document\HelperTrait\CreatedUpdatedHelperTrait;
use EveryWorkflow\MongoBundle\Document\HelperTrait\StatusHelperTrait;
use EveryWorkflow\CoreBundle\Validation\Type\StringValidation;

class StaticBlockDocument extends BaseDocument implements StaticBlockDocumentInterface
{
    use CreatedUpdatedHelperTrait;
    use StatusHelperTrait;

    #[StringValidation(required: true, minLength: 2, maxLength: 255)]
    public function setBlockTitle(string $blockTitle): self
    {
        $this->dataObject->setData(self::KEY_BLOCK_TITLE, $blockTitle);
        return $this;
    }

    public function getBlockTitle(): ?string
    {
        return $this->dataObject->getData(self::KEY_BLOCK_TITLE);
    }

    #[StringValidation(required: true, minLength: 2, maxLength: 50)]
    public function setBlockKey(string $blockKey): self
    {
        $this->dataObject->setData(self::KEY_BLOCK_KEY, $blockKey);
        return $this;
    }

    public function getBlockKey(): ?string
    {
        return $this->dataObject->getData(self::KEY_BLOCK_KEY);
    }

    public function setPageBuilderData(array $pageBuilderData): self
    {
        $this->dataObject->setData(self::KEY_PAGE_BUILDER_DATA, $pageBuilderData);
        return $this;
    }

    public function getPageBuilderData(): ?array
    {
        return $this->dataObject->getData(self::KEY_PAGE_BUILDER_DATA);
    }
}
