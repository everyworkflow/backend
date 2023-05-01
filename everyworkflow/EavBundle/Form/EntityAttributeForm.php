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
use EveryWorkflow\EavBundle\Document\AttributeGroupDocumentInterface;
use EveryWorkflow\EavBundle\Factory\AttributeFieldFactoryInterface;
use EveryWorkflow\EavBundle\Repository\BaseEntityRepositoryInterface;
use EveryWorkflow\EavBundle\Repository\HelperTrait\AttributeGroupHelperTraitInterface;

class EntityAttributeForm extends Form implements EntityAttributeFormInterface
{
    public function __construct(
        DataObjectInterface $dataObject,
        FormSectionFactoryInterface $formSectionFactory,
        FormFieldFactoryInterface $formFieldFactory,
        protected AttributeFieldFactoryInterface $attributeFieldFactory,
        protected FieldOptionFactoryInterface $fieldOptionFactory
    ) {
        parent::__construct($dataObject, $formSectionFactory, $formFieldFactory);
    }

    public function loadAttributeFields(
        BaseEntityRepositoryInterface $baseEntityRepository,
        string $attributeGroupCode = 'default'
    ): self {
        if ($baseEntityRepository instanceof AttributeGroupHelperTraitInterface) {
            $sections = $this->getSectionsForRepositoryByGroupCode($baseEntityRepository, $attributeGroupCode);
        } else {
            $sections = $this->getSectionsForRepository($baseEntityRepository);
        }
        $this->setSections($sections);

        return $this;
    }

    protected function getSectionsForRepository(
        BaseEntityRepositoryInterface $baseEntityRepository,
    ): array {
        $sections = [];

        $generalFields = [];
        try {
            $attributes = $baseEntityRepository->getAttributes();
            foreach ($attributes as $attribute) {
                if (
                    $attribute->isUsedInForm() && !in_array($attribute->getCode(), [
                    'created_at',
                    'updated_at',
                    ])
                ) {
                    $generalFields[$attribute->getCode()] = $this->attributeFieldFactory->createFromAttribute($attribute);
                }
            }
        } catch (\Exception $e) {
            // ignoring if attributes doesn't exist
        }
        $generalFields = $this->getGeneralFields($generalFields);

        $sections['general'] = $this->formSectionFactory->create([
            'section_type' => 'card_section',
            'code' => 'general',
            'title' => 'General',
            'fields' => array_values($generalFields),
        ]);

        return $sections;
    }

    protected function getGeneralFields(array $fields = []): array
    {
        $fields['_id'] = $this->getFormFieldFactory()->create([
            'name' => '_id',
            'label' => 'UUID',
            'is_readonly' => true,
            'sort_order' => 1,
        ]);

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

        return $fields;
    }

    protected function getSectionsForRepositoryByGroupCode(
        BaseEntityRepositoryInterface $baseEntityRepository,
        string $groupCode
    ): array {
        $sections = [];

        if ($baseEntityRepository instanceof AttributeGroupHelperTraitInterface) {
            $attributeData = $baseEntityRepository->getAttributeDataByGroupCode($groupCode);
            $attributeGroup = $attributeData['attribute_group'] ?? null;
            if ($attributeGroup && $attributeGroup instanceof AttributeGroupDocumentInterface) {
                $attributeGroupData = $attributeGroup->getData('attribute_group_data');
                $attributes = $attributeData['attributes'] ?? [];

                foreach ($attributeGroupData as $section) {
                    if (isset($section['code'], $section['name']) && '' !== $section['code']) {
                        $sectionFields = [];
                        foreach ($section['attributes'] as $attributeCode) {
                            if (isset($attributes[$attributeCode])) {
                                $sectionFields[$attributeCode] = $this->attributeFieldFactory->createFromAttribute(
                                    $attributes[$attributeCode]
                                );
                            }
                        }
                        if ('general' === $section['code']) {
                            $sectionFields = $this->getGeneralFields($sectionFields);
                        }
                        $sections[$section['code']] = $this->formSectionFactory->create([
                            'section_type' => 'card_section',
                            'code' => $section['code'],
                            'title' => $section['name'],
                            'fields' => array_values($sectionFields),
                        ]);
                    }
                }
            }
        }

        return $sections;
    }
}
