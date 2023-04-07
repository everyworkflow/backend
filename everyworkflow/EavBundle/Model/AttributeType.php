<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Model;

class AttributeType implements AttributeTypeInterface
{
    public function __construct(
        protected EavConfigProviderInterface $eavConfigProvider
    ) {
    }

    public function getTypes(): array
    {
        // $attributeTypes = [];
        // foreach ($this->eavConfigProvider->get('attribute_types') as $attrTypeCode => $attrClassName) {
        //     $attributeTypes[] = $attrTypeCode;
        // }
        return $this->eavConfigProvider->get('attribute_types');
    }
}
