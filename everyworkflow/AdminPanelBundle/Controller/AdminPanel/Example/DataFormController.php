<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\AdminPanelBundle\Controller\AdminPanel\Example;

use EveryWorkflow\CoreBundle\Annotation\EwRoute;
use EveryWorkflow\DataFormBundle\Factory\FieldOptionFactoryInterface;
use EveryWorkflow\DataFormBundle\Factory\FormFactoryInterface;
use EveryWorkflow\DataFormBundle\Factory\FormFieldFactoryInterface;
use EveryWorkflow\DataFormBundle\Field\Select\Option;
use EveryWorkflow\MediaManagerBundle\Field\MediaFileSelectorField;
use EveryWorkflow\MediaManagerBundle\Field\MediaImageGallerySelectorField;
use EveryWorkflow\MediaManagerBundle\Field\MediaImageSelectorField;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DataFormController extends AbstractController
{
    protected FormFactoryInterface $formFactory;
    protected FormFieldFactoryInterface $formFieldFactory;
    protected FieldOptionFactoryInterface $fieldOptionFactory;

    public function __construct(
        FormFactoryInterface $formFactory,
        FormFieldFactoryInterface $formFieldFactory,
        FieldOptionFactoryInterface $fieldOptionFactory
    ) {
        $this->formFactory = $formFactory;
        $this->formFieldFactory = $formFieldFactory;
        $this->fieldOptionFactory = $fieldOptionFactory;
    }

    #[EwRoute(
        path: 'api/admin-panel/example/data-form',
        name: 'admin_panel.example.data_form',
        methods: 'GET',
        permissions: 'auth.admin',
        swagger: true
    )]
    public function __invoke(Request $request): JsonResponse
    {
        $formBuilder = $this->formFactory->create();

        $formBuilder->setFields([
            $this->formFieldFactory->create([
                'label' => 'Name',
                'name' => 'name',
                'field_type' => 'text_field',
            ]),
            $this->formFieldFactory->create([
                'label' => 'Email address',
                'name' => 'email',
                'field_type' => 'text_field',
                'input_type' => 'email',
            ]),
            $this->formFieldFactory->create([
                'label' => 'Password',
                'name' => 'password',
                'field_type' => 'text_field',
                'input_type' => 'password',
            ]),
            $this->formFieldFactory->create([
                'label' => 'Description',
                'name' => 'description',
                'row_count' => 5,
                'field_type' => 'textarea_field',
            ]),
            $this->formFieldFactory->create([
                'label' => 'Description markdown',
                'name' => 'description_markdown',
                'field_type' => 'markdown_field',
            ]),
            $this->formFieldFactory->create([
                'label' => 'Description wysiwyg',
                'name' => 'description_wysiwyg',
                'field_type' => 'wysiwyg_field',
            ]),
            $this->formFieldFactory->create([
                'label' => 'Primary color',
                'name' => 'primary_color',
                'field_type' => 'color_picker_field',
            ]),
            $this->formFieldFactory->create([
                'label' => 'Is enabled',
                'name' => 'is_enabled',
                'field_type' => 'check_field',
            ]),
            $this->formFieldFactory->create([
                'label' => 'Is disabled',
                'name' => 'is_disabled',
                'field_type' => 'switch_field',
                'checked_label' => 'Disabled',
                'unchecked_label' => 'Enabled',
            ]),
            $this->formFieldFactory->create([
                'label' => 'Gender',
                'name' => 'gender',
                'field_type' => 'radio_field',
                'options' => [
                    $this->fieldOptionFactory->create(Option::class, [
                        'key' => 'male',
                        'value' => 'Male',
                    ]),
                    $this->fieldOptionFactory->create(Option::class, [
                        'key' => 'female',
                        'value' => 'Female',
                    ]),
                    $this->fieldOptionFactory->create(Option::class, [
                        'key' => 'other',
                        'value' => 'Other',
                    ]),
                ],
            ]),
            $this->formFieldFactory->create([
                'label' => 'Gender selector',
                'name' => 'gender_selector',
                'field_type' => 'select_field',
                'options' => [
                    $this->fieldOptionFactory->create(Option::class, [
                        'key' => 'male',
                        'value' => 'Male',
                    ]),
                    $this->fieldOptionFactory->create(Option::class, [
                        'key' => 'female',
                        'value' => 'Female',
                    ]),
                    $this->fieldOptionFactory->create(Option::class, [
                        'key' => 'other',
                        'value' => 'Other',
                    ]),
                ],
            ]),
            $this->formFieldFactory->create([
                'label' => 'Gender selector searchable',
                'name' => 'gender_selector_searchable',
                'field_type' => 'select_field',
                'is_searchable' => true,
                'options' => [
                    $this->fieldOptionFactory->create(Option::class, [
                        'key' => 'male',
                        'value' => 'Male',
                    ]),
                    $this->fieldOptionFactory->create(Option::class, [
                        'key' => 'female',
                        'value' => 'Female',
                    ]),
                    $this->fieldOptionFactory->create(Option::class, [
                        'key' => 'other',
                        'value' => 'Other',
                    ]),
                ],
            ]),
            $this->formFieldFactory->create([
                'label' => 'Date of birth',
                'name' => 'dob',
                'field_type' => 'date_picker_field',
                'value' => '1997-06-02',
            ]),
            $this->formFieldFactory->create([
                'label' => 'Time of birth',
                'name' => 'tob',
                'field_type' => 'time_picker_field',
                'value' => '08:45:16',
            ]),
            $this->formFieldFactory->create([
                'label' => 'Deleted at',
                'name' => 'deleted_at',
                'field_type' => 'date_time_picker_field',
                'value' => '2019-08-12 08:45:16',
            ]),
            $this->formFieldFactory->create([
                'label' => 'Leave date range',
                'name' => 'leave_date_range',
                'field_type' => 'date_range_picker_field',
                'value' => ['2019-08-12', '2019-08-19'],
            ]),
            $this->formFieldFactory->create([
                'label' => 'Break time range',
                'name' => 'break_time_range',
                'field_type' => 'time_range_picker_field',
                'value' => ['08:15:20', '12:25:35'],
            ]),
            $this->formFieldFactory->create([
                'label' => 'Black friday sale date range',
                'name' => 'black_friday_sale_date_range',
                'field_type' => 'date_time_range_picker_field',
                'value' => ['2019-08-12 08:45:30', '2019-08-26 22:15:30'],
            ]),
            $this->formFieldFactory->create([
                'label' => 'Input group field',
                'name' => 'input_group_field',
                'field_type' => 'text_field',
                'prefix_text' => 'https://example.com/',
                'suffix_text' => '@example.com',
            ]),
            $this->formFieldFactory->create([
                'label' => 'Media image selector field',
                'name' => 'media_image_selector_field',
                'field_type' => 'media_image_selector_field',
                'upload_path' => '/media/example',
            ]),
            $this->formFieldFactory->create([
                'label' => 'Media image gallery selector field',
                'name' => 'media_image_gallery_selector_field',
                'field_type' => 'media_image_gallery_selector_field',
                'upload_path' => '/media/example',
            ]),
            $this->formFieldFactory->create([
                'label' => 'Media file selector field',
                'name' => 'media_file_selector_field',
                'field_type' => 'media_file_selector_field',
                'upload_path' => '/media/example',
            ]),
            $this->formFieldFactory->create([
                'label' => 'Media image uploader field',
                'name' => 'media_image_uploader_field',
                'field_type' => 'media_image_uploader_field',
                'upload_path' => '/media-manager/upload-image?path=/media/example',
            ]),
            $this->formFieldFactory->create([
                'label' => 'Media image gallery uploader field',
                'name' => 'media_image_gallery_uploader_field',
                'field_type' => 'media_image_gallery_uploader_field',
                'upload_path' => '/media-manager/upload-image?path=/media/example',
            ]),
            $this->formFieldFactory->create([
                'label' => 'Media file uploader field',
                'name' => 'media_file_uploader_field',
                'field_type' => 'media_file_uploader_field',
                'upload_path' => '/media-manager/upload?path=/media/example',
            ]),
        ]);

        return new JsonResponse($formBuilder->toArray());
    }
}
