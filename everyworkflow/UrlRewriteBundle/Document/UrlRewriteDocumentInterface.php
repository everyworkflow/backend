<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\UrlRewriteBundle\Document;

use EveryWorkflow\MongoBundle\Document\BaseDocumentInterface;
use EveryWorkflow\MongoBundle\Document\HelperTrait\CreatedUpdatedHelperTraitInterface;
use EveryWorkflow\MongoBundle\Document\HelperTrait\StatusHelperTraitInterface;

interface UrlRewriteDocumentInterface extends BaseDocumentInterface, CreatedUpdatedHelperTraitInterface, StatusHelperTraitInterface
{
    public const KEY_URL = 'url';
    public const KEY_TYPE = 'type';
    public const KEY_TYPE_KEY = 'type_key';

    public function setUrl(string $url): self;

    public function getUrl(): ?string;

    public function setType(string $type): self;

    public function getType(): ?string;

    public function setTypeKey(string $typeKey): self;

    public function getTypeKey(): ?string;
}
