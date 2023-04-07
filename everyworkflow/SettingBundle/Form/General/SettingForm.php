<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\SettingBundle\Form\General;

use EveryWorkflow\DataFormBundle\Model\Form;

class SettingForm extends Form implements SettingFormInterface
{
    /**
     * @return BaseSectionInterface[]
     */
    public function getSections(): array
    {
        $sections = [
            $this->getFormSectionFactory()->create([
                'section_type' => 'card_section',
                'title' => 'General',
            ])->setFields($this->getGeneralFields()),
        ];

        return array_merge($sections, parent::getSections());
    }

    protected function getGeneralFields(): array
    {
        $fields = [
            $this->formFieldFactory->create([
                'label' => 'System Name',
                'name' => 'system_name',
                'field_type' => 'text_field',
                'is_required' => true,
            ]),

            $this->formFieldFactory->create([
                'label' => 'System Name',
                'name' => 'system_name1',
                'field_type' => 'text_field',
                'is_required' => true,
            ]),
            $this->formFieldFactory->create([
                'label' => 'System Name',
                'name' => 'system_name2',
                'field_type' => 'text_field',
                'is_required' => true,
            ]),
            $this->formFieldFactory->create([
                'label' => 'System Name',
                'name' => 'system_name3',
                'field_type' => 'text_field',
                'is_required' => true,
            ]),
            $this->formFieldFactory->create([
                'label' => 'System Name',
                'name' => 'system_name4',
                'field_type' => 'text_field',
                'is_required' => true,
            ]),
            $this->formFieldFactory->create([
                'label' => 'System Name',
                'name' => 'system_name5',
                'field_type' => 'text_field',
                'is_required' => true,
            ]),
            $this->formFieldFactory->create([
                'label' => 'System Name',
                'name' => 'system_name6',
                'field_type' => 'text_field',
                'is_required' => true,
            ]),
            $this->formFieldFactory->create([
                'label' => 'System Name',
                'name' => 'system_name7',
                'field_type' => 'text_field',
                'is_required' => true,
            ]),
            $this->formFieldFactory->create([
                'label' => 'System Name',
                'name' => 'system_name8',
                'field_type' => 'text_field',
                'is_required' => true,
            ]),

            $this->formFieldFactory->create([
                'label' => 'Language',
                'name' => 'language',
                'field_type' => 'select_field',
                'options' => [
                    [
                        'key' => 'english',
                        'value' => 'English',
                    ],
                ],
                'is_required' => true,
            ]),
            $this->formFieldFactory->create([
                'label' => 'Timezone',
                'name' => 'timezone',
                'field_type' => 'select_field',
                'options' => $this->getAllTimeZoneOptions(),
                'is_required' => true,
                'is_searchable' => true,
            ]),
        ];

        $sortOrder = 5;
        foreach ($fields as $field) {
            $field->setSortOrder($sortOrder++);
        }

        return $fields;
    }

    protected function getAllTimeZoneOptions(): array
    {
        $allTimeZones = [
            'Pacific/Midway' => 'Midway Island, Samoa',
            'Pacific/Honolulu' => 'Hawaii',
            'America/Juneau' => 'Alaska',
            'America/Boise' => 'Mountain Time',
            'America/Dawson' => 'Dawson, Yukon',
            'America/Chihuahua' => 'Chihuahua, La Paz, Mazatlan',
            'America/Phoenix' => 'Arizona',
            'America/Chicago' => 'Central Time',
            'America/Regina' => 'Saskatchewan',
            'America/Mexico_City' => 'Guadalajara, Mexico City, Monterrey',
            'America/Belize' => 'Central America',
            'America/Detroit' => 'Eastern Time',
            'America/Bogota' => 'Bogota, Lima, Quito',
            'America/Caracas' => 'Caracas, La Paz',
            'America/Santiago' => 'Santiago',
            'America/St_Johns' => 'Newfoundland and Labrador',
            'America/Sao_Paulo' => 'Brasilia',
            'America/Tijuana' => 'Tijuana',
            'America/Montevideo' => 'Montevideo',
            'America/Argentina/Buenos_Aires' => 'Buenos Aires, Georgetown',
            'America/Godthab' => 'Greenland',
            'America/Los_Angeles' => 'Pacific Time',
            'Atlantic/Azores' => 'Azores',
            'Atlantic/Cape_Verde' => 'Cape Verde Islands',
            'GMT' => 'UTC',
            'Europe/London' => 'Edinburgh, London',
            'Europe/Dublin' => 'Dublin',
            'Europe/Lisbon' => 'Lisbon',
            'Africa/Casablanca' => 'Casablanca, Monrovia',
            'Atlantic/Canary' => 'Canary Islands',
            'Europe/Belgrade' => 'Belgrade, Bratislava, Budapest, Ljubljana, Prague',
            'Europe/Sarajevo' => 'Sarajevo, Skopje, Warsaw, Zagreb',
            'Europe/Brussels' => 'Brussels, Copenhagen, Madrid, Paris',
            'Europe/Amsterdam' => 'Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna',
            'Africa/Algiers' => 'West Central Africa',
            'Europe/Bucharest' => 'Bucharest',
            'Africa/Cairo' => 'Cairo',
            'Europe/Helsinki' => 'Helsinki, Kiev, Riga, Sofia, Tallinn, Vilnius',
            'Europe/Athens' => 'Athens, Minsk',
            'Asia/Jerusalem' => 'Jerusalem',
            'Africa/Harare' => 'Harare, Pretoria',
            'Europe/Moscow' => 'Istanbul, Moscow, St. Petersburg, Volgograd',
            'Asia/Kuwait' => 'Kuwait, Riyadh',
            'Africa/Nairobi' => 'Nairobi',
            'Asia/Baghdad' => 'Baghdad',
            'Asia/Tehran' => 'Tehran',
            'Asia/Dubai' => 'Abu Dhabi, Muscat',
            'Asia/Baku' => 'Baku, Tbilisi, Yerevan',
            'Asia/Kabul' => 'Kabul',
            'Asia/Yekaterinburg' => 'Ekaterinburg',
            'Asia/Karachi' => 'Islamabad, Karachi, Tashkent',
            'Asia/Kolkata' => 'Chennai, Kolkata, Mumbai, New Delhi',
            'Asia/Kathmandu' => 'Kathmandu',
            'Asia/Dhaka' => 'Astana, Dhaka',
            'Asia/Colombo' => 'Sri Jayawardenepura',
            'Asia/Almaty' => 'Almaty, Novosibirsk',
            'Asia/Rangoon' => 'Yangon Rangoon',
            'Asia/Bangkok' => 'Bangkok, Hanoi, Jakarta',
            'Asia/Krasnoyarsk' => 'Krasnoyarsk',
            'Asia/Shanghai' => 'Beijing, Chongqing, Hong Kong SAR, Urumqi',
            'Asia/Kuala_Lumpur' => 'Kuala Lumpur, Singapore',
            'Asia/Taipei' => 'Taipei',
            'Australia/Perth' => 'Perth',
            'Asia/Irkutsk' => 'Irkutsk, Ulaanbaatar',
            'Asia/Seoul' => 'Seoul',
            'Asia/Tokyo' => 'Osaka, Sapporo, Tokyo',
            'Asia/Yakutsk' => 'Yakutsk',
            'Australia/Darwin' => 'Darwin',
            'Australia/Adelaide' => 'Adelaide',
            'Australia/Sydney' => 'Canberra, Melbourne, Sydney',
            'Australia/Brisbane' => 'Brisbane',
            'Australia/Hobart' => 'Hobart',
            'Asia/Vladivostok' => 'Vladivostok',
            'Pacific/Guam' => 'Guam, Port Moresby',
            'Asia/Magadan' => 'Magadan, Solomon Islands, New Caledonia',
            'Asia/Kamchatka' => 'Kamchatka, Marshall Islands',
            'Pacific/Fiji' => 'Fiji Islands',
            'Pacific/Auckland' => 'Auckland, Wellington',
            'Pacific/Tongatapu' => "Nuku'alofa",
        ];

        $options = [];
        foreach ($allTimeZones as $key => $val) {
            $options[] = [
                'key' => $key,
                'value' => $val,
            ];
        }

        return $options;
    }
}
