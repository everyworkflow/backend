<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Repository\HelperTrait;

interface AttributeGroupHelperTraitInterface
{
    public function getAttributeGroups(): array;

    public function getAttributeDataByGroupCode(string $groupCode): ?array;

    public function getFormByGroupCode(string $groupCode): array;
}
