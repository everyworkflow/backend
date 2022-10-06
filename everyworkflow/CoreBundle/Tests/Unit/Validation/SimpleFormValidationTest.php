<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CoreBundle\Tests\Unit\Validation;

use EveryWorkflow\CoreBundle\Tests\BaseTestCase;

class SimpleFormValidationTest extends BaseTestCase
{
    public function test_it_should_be_able_to_validate_a_simple_form()
    {
        $validator = $this->getValidatorFactory()->create([
            'name' => [
                'type' => 'string',
                'min_length' => 10,
                'max_length' => 15,
            ],
            'age' => [
                'type' => 'number',
                'required' => true,
                'minimum' => 18,
                'maximum' => 24,
            ],
            'is_policy_accepted' => [
                'type' => 'boolean',
                'property_name' => 'Is policy accepted'
            ],
            'date_of_birth' => [
                'type' => 'date_time',
                'required' => true,
                'min_date' => '1970-01-01',
                'max_date' => '2000-01-01',
                'format' => 'Y-m-d',
            ],
            'hobbies' => [
                'type' => 'array',
                'rules' => [
                    'type' => 'string',
                    'min_length' => 2,
                    'max_length' => 15,
                ],
            ],
            'likes' => [
                'type' => 'array',
                'rules' => [
                    'books' => [
                        'type' => 'array',
                        'rules' => [
                            'type' => 'string',
                            'min_length' => 10,
                            'max_length' => 150,
                        ],
                    ],
                    'do_you_like_movies' => [
                        'type' => 'boolean',
                        'required' => true,
                    ],
                ],
            ],
        ]);
        $validatorResult = $validator->validate([
            'name' => 'Testing Name',
            'age' => '18.5',
            'is_policy_accepted' => true,
            'date_of_birth' => '1985-12-31T18:14:59.626Z',
            'hobbies' => [
                'sport',
                'cooking',
                'reading',
            ],
            'likes' => [
                'books' => [
                    'The Lord of the Rings',
                    'The Hobbit',
                ],
                'do_you_like_movies' => true,
            ],
        ]);
        $this->assertTrue($validatorResult);
    }
}
