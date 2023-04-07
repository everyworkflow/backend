<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\MediaManagerBundle\Form\Attribute;

use EveryWorkflow\EavBundle\Form\AttributeForm;

class MediaAttributeForm extends AttributeForm implements MediaAttributeFormInterface
{
    /**
     * @return BaseSectionInterface[]
     */
    public function getSections(): array
    {
        $sections = [
            $this->getFormSectionFactory()->create([
                'section_type' => 'card_section',
                'code' => 'form_field',
                'title' => 'Form Field',
                'sort_order' => 10000,
            ])->setFields([
                $this->formFieldFactory->create([
                    'label' => 'Field type',
                    'name' => 'field_type',
                    'field_type' => 'select_field',
                    'default' => 'text',
                    'options' => [
                        [
                            'key' => 'media_file_uploader_field',
                            'value' => 'Media file uploader field',
                        ],
                        [
                            'key' => 'media_image_uploader_field',
                            'value' => 'Media image uploader field',
                        ],
                        [
                            'key' => 'media_image_gallery_uploader_field',
                            'value' => 'Media image gallery uploader field',
                        ],
                        [
                            'key' => 'media_file_selector_field',
                            'value' => 'media file selector field',
                        ],
                        [
                            'key' => 'media_image_selector_field',
                            'value' => 'Media image selector field',
                        ],
                        [
                            'key' => 'media_image_gallery_selector_field',
                            'value' => 'Media image gallery selector field',
                        ],
                    ],
                ]),
            ]),
        ];
        return array_merge(parent::getSections(), $sections);
    }

    public function toArray(): array
    {
        $this->dataObject->setDataIfNot(self::KEY_IS_SIDE_FORM_ANCHOR_ENABLE, true);
        return parent::toArray();
    }
}
