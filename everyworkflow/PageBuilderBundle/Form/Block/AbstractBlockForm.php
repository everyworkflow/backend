<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\PageBuilderBundle\Form\Block;

use EveryWorkflow\CoreBundle\Model\DataObjectInterface;
use EveryWorkflow\DataFormBundle\Factory\FieldOptionFactoryInterface;
use EveryWorkflow\DataFormBundle\Factory\FormFieldFactoryInterface;
use EveryWorkflow\DataFormBundle\Factory\FormSectionFactoryInterface;
use EveryWorkflow\DataFormBundle\Model\Form;

abstract class AbstractBlockForm extends Form implements AbstractBlockFormInterface
{
    protected FieldOptionFactoryInterface $fieldOptionFactory;

    public function __construct(
        DataObjectInterface $dataObject,
        FormSectionFactoryInterface $formSectionFactory,
        FormFieldFactoryInterface $formFieldFactory,
        FieldOptionFactoryInterface $fieldOptionFactory
    ) {
        parent::__construct($dataObject, $formSectionFactory, $formFieldFactory);
        $this->dataObject->setDataIfNot(self::KEY_PANEL_SIZE, self::PANEL_SIZE_MEDIUM);
        $this->fieldOptionFactory = $fieldOptionFactory;
    }

    public function getPanelSize(): string
    {
        return $this->dataObject->getData(self::KEY_PANEL_SIZE);
    }

    public function setPanelSize(string $panelSize): self
    {
        $this->dataObject->setData(self::KEY_PANEL_SIZE, $panelSize);
        return $this;
    }

    public function getFields(): array
    {
        $fields = [
            $this->formFieldFactory->create([
                'label' => 'CSS classname',
                'name' => 'classname',
                'field_type' => 'text_field',
            ]),
            $this->formFieldFactory->create([
                'label' => 'JSX style',
                'name' => 'style',
                'field_type' => 'textarea_field',
            ]),
        ];
        return array_merge($fields, parent::getFields());
    }
}
