<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Document;

use EveryWorkflow\MongoBundle\Document\BaseDocumentInterface;
use EveryWorkflow\MongoBundle\Document\HelperTrait\CreatedUpdatedHelperTraitInterface;
use EveryWorkflow\MongoBundle\Document\HelperTrait\StatusHelperTraitInterface;

interface AttributeDocumentInterface extends BaseDocumentInterface,
    CreatedUpdatedHelperTraitInterface,
    StatusHelperTraitInterface
{
    public const KEY_CODE = 'code';
    public const KEY_NAME = 'name';
    public const KEY_TYPE = 'type';
    public const KEY_CLASS = 'class';
    public const KEY_ENTITY_CODE = 'entity_code';
    public const KEY_IS_REQUIRED = 'is_required';
    public const KEY_IS_READONLY = 'is_readonly';
    public const KEY_IS_USED_IN_GRID = 'is_used_in_grid';
    public const KEY_IS_USED_IN_FORM = 'is_used_in_form';
    public const KEY_SORT_ORDER = 'sort_order';

    public function setCode(string $code): self;

    public function getCode(): ?string;

    public function setName(string $name): self;

    public function getName(): ?string;

    public function setType(string $type): self;

    public function getType(): ?string;

    public function setClass(string $className): self;

    public function getClass(): ?string;

    public function setEntityCode(string $entityCode): self;

    public function getEntityCode(): ?string;

    public function setIsRequired(bool $isRequired): self;

    public function isRequired(): bool;

    public function setIsReadonly(bool $isReadonly): self;

    public function isReadonly(): bool;

    public function setIsUsedInGrid(bool $isUsedInGrid): self;

    public function isUsedInGrid(): bool;

    public function setIsUsedInForm(bool $isUsedInForm): self;

    public function isUsedInForm(): bool;

    public function setSortOrder(int $sortOrder): self;

    public function getSortOrder(): ?int;
}
