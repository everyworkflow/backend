<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Tests\Unit;

use EveryWorkflow\DataGridBundle\Tests\BaseGridTestCase;
use EveryWorkflow\EavBundle\Model\EavConfigProvider;
use EveryWorkflow\EavBundle\Model\EavConfigProviderInterface;

class BaseEavTestCase extends BaseGridTestCase
{
    protected function getEavConfigProvider(array $configs = []): EavConfigProviderInterface
    {
        return new EavConfigProvider([
            'default' => [
                'entity_class' => 'EveryWorkflow\EavBundle\Entity\BaseEntity',
                'attribute_class' => 'EveryWorkflow\EavBundle\Attribute\BaseAttribute',
                'attribute_field_mapper_class' => 'EveryWorkflow\EavBundle\Attribute\BaseFieldMapper',
                'attribute_type' => 'text_attribute',
                'attribute_field' => 'text_field',
            ],
            'entity_types' => [
                'base_entity' => 'EveryWorkflow\EavBundle\Entity\BaseEntity',
            ],
            'attribute_types' => [
                'text_attribute' => 'EveryWorkflow\EavBundle\Attribute\Type\TextAttribute',
                'long_text_attribute' => 'EveryWorkflow\EavBundle\Attribute\Type\LongTextAttribute',
                'select_attribute' => 'EveryWorkflow\EavBundle\Attribute\Type\SelectAttribute',
                'multi_select_attribute' => 'EveryWorkflow\EavBundle\Attribute\Type\MultiSelectAttribute',
                'number_attribute' => 'EveryWorkflow\EavBundle\Attribute\Type\NumberAttribute',
                'currency_attribute' => 'EveryWorkflow\EavBundle\Attribute\Type\CurrencyAttribute',
                'swatch_attribute' => 'EveryWorkflow\EavBundle\Attribute\Type\SwatchAttribute',
                'date_attribute' => 'EveryWorkflow\EavBundle\Attribute\Type\DateAttribute',
                'date_time_attribute' => 'EveryWorkflow\EavBundle\Attribute\Type\DateTimeAttribute',
                'boolean_attribute' => 'EveryWorkflow\EavBundle\Attribute\Type\BooleanAttribute',
            ],
            'attribute_type_to_form_field_mapper' => [
                'text_attribute' => 'EveryWorkflow\EavBundle\Attribute\FieldMapper\TextMapper',
                'long_text_attribute' => 'EveryWorkflow\EavBundle\Attribute\FieldMapper\LongTextMapper',
                'select_attribute' => 'EveryWorkflow\EavBundle\Attribute\FieldMapper\SelectMapper',
                'multi_select_attribute' => 'EveryWorkflow\EavBundle\Attribute\FieldMapper\MultiSelectMapper',
                'number_attribute' => 'EveryWorkflow\EavBundle\Attribute\FieldMapper\NumberMapper',
                'currency_attribute' => 'EveryWorkflow\EavBundle\Attribute\FieldMapper\CurrencyMapper',
                'swatch_attribute' => 'EveryWorkflow\EavBundle\Attribute\FieldMapper\SwatchMapper',
                'date_attribute' => 'EveryWorkflow\EavBundle\Attribute\FieldMapper\DateMapper',
                'date_time_attribute' => 'EveryWorkflow\EavBundle\Attribute\FieldMapper\DateTimeMapper',
                'boolean_attribute' => 'EveryWorkflow\EavBundle\Attribute\FieldMapper\BooleanAttribute',
            ],
            ...$configs,
        ]);
    }
}
