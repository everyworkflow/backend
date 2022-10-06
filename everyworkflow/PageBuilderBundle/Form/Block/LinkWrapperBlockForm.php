<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\PageBuilderBundle\Form\Block;

use EveryWorkflow\DataFormBundle\Field\Select\Option;

class LinkWrapperBlockForm extends AbstractBlockForm implements LinkWrapperBlockFormInterface
{
    public function getFields(): array
    {
        $fields = [
            $this->formFieldFactory->create([
                'label' => 'Link path',
                'name' => 'link_path',
                'field_type' => 'text_field',
            ]),
            $this->formFieldFactory->create([
                'label' => 'Link target',
                'name' => 'link_target',
                'field_type' => 'select_field',
                'options' => [
                    $this->fieldOptionFactory->create(Option::class, [
                        'key' => '',
                        'value' => 'Default',
                    ]),
                    $this->fieldOptionFactory->create(Option::class, [
                        'key' => '_blank',
                        'value' => 'Blank - Opens in a new window or tab',
                    ]),
                    $this->fieldOptionFactory->create(Option::class, [
                        'key' => '_self',
                        'value' => 'Self - Opens in the same frame as it was clicked (default)',
                    ]),
                    $this->fieldOptionFactory->create(Option::class, [
                        'key' => '_parent',
                        'value' => 'Parent - Opens in the parent frame',
                    ]),
                    $this->fieldOptionFactory->create(Option::class, [
                        'key' => '_top',
                        'value' => 'Top - Opens in the named iframe',
                    ]),
                ],
            ]),
        ];

        return array_merge($fields, parent::getFields());
    }
}
