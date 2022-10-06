<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\StaticBlockBundle\Document;

use EveryWorkflow\MongoBundle\Document\BaseDocumentInterface;
use EveryWorkflow\MongoBundle\Document\HelperTrait\CreatedUpdatedHelperTraitInterface;
use EveryWorkflow\MongoBundle\Document\HelperTrait\StatusHelperTraitInterface;

interface StaticBlockDocumentInterface extends BaseDocumentInterface,
    CreatedUpdatedHelperTraitInterface,
    StatusHelperTraitInterface
{
    public const KEY_BLOCK_TITLE = 'block_title';
    public const KEY_BLOCK_KEY = 'block_key';
    public const KEY_PAGE_BUILDER_DATA = 'page_builder_data';

    public function setBlockTitle(string $blockTitle): self;

    public function getBlockTitle(): ?string;

    public function setBlockKey(string $blockKey): self;

    public function getBlockKey(): ?string;

    public function setPageBuilderData(array $pageBuilderData): self;

    public function getPageBuilderData(): ?array;
}
