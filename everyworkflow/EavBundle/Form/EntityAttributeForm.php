<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Form;

use EveryWorkflow\CoreBundle\Model\DataObjectInterface;
use EveryWorkflow\DataFormBundle\Factory\FieldOptionFactoryInterface;
use EveryWorkflow\DataFormBundle\Factory\FormFieldFactoryInterface;
use EveryWorkflow\DataFormBundle\Factory\FormSectionFactoryInterface;
use EveryWorkflow\DataFormBundle\Field\Select\Option;
use EveryWorkflow\DataFormBundle\Model\Form;
use EveryWorkflow\EavBundle\Factory\AttributeFieldFactoryInterface;
use EveryWorkflow\EavBundle\Repository\BaseEntityRepositoryInterface;

class EntityAttributeForm extends Form implements EntityAttributeFormInterface
{
    protected AttributeFieldFactoryInterface $attributeFieldFactory;
    protected FieldOptionFactoryInterface $fieldOptionFactory;

    public function __construct(
        DataObjectInterface $dataObject,
        FormSectionFactoryInterface $formSectionFactory,
        FormFieldFactoryInterface $formFieldFactory,
        AttributeFieldFactoryInterface $attributeFieldFactory,
        FieldOptionFactoryInterface $fieldOptionFactory
    ) {
        parent::__construct($dataObject, $formSectionFactory, $formFieldFactory);
        $this->attributeFieldFactory = $attributeFieldFactory;
        $this->fieldOptionFactory = $fieldOptionFactory;
    }

    public function loadAttributeFields(BaseEntityRepositoryInterface $baseEntityRepository): self
    {
        $fields = [
            '_id' => $this->getFormFieldFactory()->create([
                'name' => '_id',
                'label' => 'UUID',
                'is_readonly' => true,
                'sort_order' => 1,
            ])
        ];

        try {
            $attributes = $baseEntityRepository->getAttributes();
            foreach ($attributes as $attribute) {
                if ($attribute->isUsedInForm() && !in_array($attribute->getCode(), [
                    'created_at',
                    'updated_at',
                ])) {
                    $fields[$attribute->getCode()] = $this->attributeFieldFactory->createFromAttribute($attribute);
                }
            }
        } catch (\Exception $e) {
            // ignoring if attributes doesn't exist
        }

        if (!isset($fields['status'])) {
            $fields['status'] = $this->formFieldFactory->create([
                'label' => 'Status',
                'name' => 'status',
                'field_type' => 'select_field',
                'options' => [
                    $this->fieldOptionFactory->create(Option::class, [
                        'key' => 'enable',
                        'value' => 'Enable',
                    ]),
                    $this->fieldOptionFactory->create(Option::class, [
                        'key' => 'disable',
                        'value' => 'Disable',
                    ]),
                ],
                'sort_order' => 2,
            ]);
        }

        $fields['created_at'] = $this->formFieldFactory->create([
            'label' => 'Created at',
            'name' => 'created_at',
            'is_readonly' => true,
            'field_type' => 'date_time_picker_field',
            'sort_order' => 10000,
        ]);
        $fields['updated_at'] = $this->formFieldFactory->create([
            'label' => 'Updated at',
            'name' => 'updated_at',
            'is_readonly' => true,
            'field_type' => 'date_time_picker_field',
            'sort_order' => 10001,
        ]);

        $this->setSections([
            $this->formSectionFactory->create([
                'section_type' => 'card_section',
                'code' => 'general',
                'title' => 'General',
                'fields' => array_values($fields),
            ]),
        ]);

        return $this;
    }
}
