<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\ScopeBundle\Document;

use EveryWorkflow\MongoBundle\Document\BaseDocumentInterface;
use EveryWorkflow\MongoBundle\Document\HelperTrait\CreatedUpdatedHelperTraitInterface;
use EveryWorkflow\MongoBundle\Document\HelperTrait\StatusHelperTraitInterface;

interface ScopeDocumentInterface extends BaseDocumentInterface, CreatedUpdatedHelperTraitInterface, StatusHelperTraitInterface
{
    public const KEY_CODE = 'code';
    public const KEY_NAME = 'name';
    public const KEY_PARENT = 'parent';
    public const KEY_SORT_ORDER = 'sort_order';
    public const KEY_CHILDREN = 'children';

    public const DEFAULT_CODE = 'default';

    public const ADMIN_SCOPE_CODE = 'admin';

    public const FRONTEND_SCOPE_CODE = 'frontend';

    public function setCode(string $code): self;

    public function getCode(): ?string;

    public function setName($name): self;

    public function getName(): ?string;

    public function setParent(string $parentCode): self;

    public function getParent(): ?string;

    public function setSortOrder($sortOrder): self;

    public function getSortOrder(): ?int;

    public function setChildren(array $sortOrder): self;

    public function getChildren(): ?array;
}
