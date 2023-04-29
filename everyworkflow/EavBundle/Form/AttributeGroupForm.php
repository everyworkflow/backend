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
use EveryWorkflow\DataFormBundle\Field\Select\OptionInterface;
use EveryWorkflow\DataFormBundle\Model\Form;
use EveryWorkflow\EavBundle\Document\EntityDocumentInterface;
use EveryWorkflow\EavBundle\Repository\EntityRepositoryInterface;

class AttributeGroupForm extends Form implements AttributeGroupFormInterface
{
    public function __construct(
        protected EntityRepositoryInterface $entityRepository,
        protected FieldOptionFactoryInterface $fieldOptionFactory,
        DataObjectInterface $dataObject,
        FormSectionFactoryInterface $formSectionFactory,
        FormFieldFactoryInterface $formFieldFactory
    ) {
        parent::__construct($dataObject, $formSectionFactory, $formFieldFactory);
    }

    /**
     * @return BaseSectionInterface[]
     */
    public function getSections(): array
    {
        $sections = [
            $this->getFormSectionFactory()->create([
                'section_type' => 'card_section',
                'code' => 'general',
                'title' => 'General',
                'sort_order' => 1,
            ])->setFields($this->getGeneralFields()),
            $this->getFormSectionFactory()->create([
                'section_type' => 'card_section',
                'code' => 'attribute_group',
                'title' => 'Attribute group',
                'sort_order' => 100,
            ]),
        ];

        return array_merge($sections, parent::getSections());
    }

    protected function getGeneralFields(): array
    {
        $fields = [
            $this->formFieldFactory->create([
                'label' => 'UUID',
                'name' => '_id',
                'is_readonly' => true,
            ]),
            $this->formFieldFactory->create([
                'label' => 'Entity code',
                'name' => 'entity_code',
                'field_type' => 'select_field',
                'is_actionable' => true,
                ...$this->getEntityCodeOptionsAndActions(),
                'is_required' => true,
            ]),
            $this->formFieldFactory->create([
                'label' => 'Code',
                'name' => 'code',
                'is_required' => true,
            ]),
            $this->formFieldFactory->create([
                'label' => 'Name',
                'name' => 'name',
                'is_required' => true,
            ]),
            $this->formFieldFactory->create([
                'label' => 'Status',
                'name' => 'status',
                'field_type' => 'select_field',
                'options' => [
                    [
                        'key' => 'enable',
                        'value' => 'Enable',
                    ],
                    [
                        'key' => 'disable',
                        'value' => 'Disable',
                    ],
                ],
            ]),
            $this->formFieldFactory->create([
                'label' => 'Sort order',
                'name' => 'sort_order',
                'field_type' => 'text_field',
                'input_type' => 'number',
            ]),
            $this->formFieldFactory->create([
                'label' => 'Created at',
                'name' => 'created_at',
                'is_readonly' => true,
                'field_type' => 'date_time_picker_field',
            ]),
            $this->formFieldFactory->create([
                'label' => 'Updated at',
                'name' => 'updated_at',
                'is_readonly' => true,
                'field_type' => 'date_time_picker_field',
            ]),
        ];

        $sortOrder = 5;
        foreach ($fields as $field) {
            $field->setSortOrder($sortOrder++);
        }

        return $fields;
    }

    protected function getEntityCodeOptionsAndActions(): array
    {
        $options = [];
        $fieldActions = [];
        $sortOrder = 1;

        try {
            $entities = $this->entityRepository->find();
        } catch (\ReflectionException $e) {
            $entities = [];
        }

        /** @var EntityDocumentInterface $item */
        foreach ($entities as $item) {
            /** @var OptionInterface $option */
            $option = $this->fieldOptionFactory->create(Option::class, [
                'key' => $item->getCode(),
                'value' => $item->getName(),
                'sort_order' => $sortOrder,
            ]);
            ++$sortOrder;
            $options[] = $option;
            $fieldActions[$item->getCode()] = [
                [
                    'action_type' => 'update_form',
                ],
            ];
        }

        return [
            'options' => $options,
            'field_actions' => $fieldActions,
        ];
    }

    public function toArray(): array
    {
        $this->dataObject->setDataIfNot(self::KEY_FORM_UPDATE_PATH, '/eav/attribute-group/additional-form');

        return parent::toArray();
    }
}
