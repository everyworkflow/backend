<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Document;

use EveryWorkflow\MongoBundle\Document\BaseDocumentInterface;
use EveryWorkflow\MongoBundle\Document\HelperTrait\CreatedUpdatedHelperTraitInterface;
use EveryWorkflow\MongoBundle\Document\HelperTrait\StatusHelperTraitInterface;

interface EntityDocumentInterface extends BaseDocumentInterface,
    CreatedUpdatedHelperTraitInterface,
    StatusHelperTraitInterface
{
    public const KEY_CODE = 'code';
    public const KEY_CLASS = 'class';
    public const KEY_NAME = 'name';

    public function getId(): ?string;

    public function setCode(string $code): self;

    public function getCode(): ?string;

    public function setClass(string $class): self;

    public function getClass(): ?string;

    public function setName(string $name): self;

    public function getName(): ?string;
}
