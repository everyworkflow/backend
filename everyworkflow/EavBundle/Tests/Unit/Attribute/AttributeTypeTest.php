<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Tests\Unit\Attribute;

use EveryWorkflow\DataFormBundle\Factory\FormFieldFactoryInterface;
use EveryWorkflow\EavBundle\Factory\AttributeFactory;
use EveryWorkflow\EavBundle\Tests\Unit\BaseEavTestCase;

class AttributeTypeTest extends BaseEavTestCase
{
    protected FormFieldFactoryInterface $formFieldFactory;
    protected AttributeFactory $attributeFactory;

    protected function setUp(): void
    {
        parent::setUp();
        $container = self::getContainer();
        $this->formFieldFactory = $this->getFormFieldFactory($container);
        $this->attributeFactory = new AttributeFactory(
            $this->getDataObjectFactory(),
            $container,
            $this->getEavConfigProvider(),
        );
    }

    public function testTextAttribute(): void
    {
        $textField = $this->attributeFactory->createAttribute([
            'name' => 'First name',
            'code' => 'first_name',
        ]);
        self::assertEquals('First name', $textField->toArray()['name']);
        self::assertEquals('first_name', $textField->toArray()['code']);
        self::assertEquals('text_attribute', $textField->toArray()['type']);
    }

    public function testLongTextAttribute()
    {
        $textAreaField = $this->attributeFactory->createAttribute([
            'name' => 'Description',
            'code' => 'description',
            'type' => 'long_text_attribute',
        ]);
        self::assertEquals('Description', $textAreaField->toArray()['name']);
        self::assertEquals('description', $textAreaField->toArray()['code']);
        self::assertEquals('long_text_attribute', $textAreaField->toArray()['type']);
    }

    public function testSelectAttribute()
    {
        $selectField = $this->attributeFactory->createAttribute([
            'name' => 'Country',
            'code' => 'country',
            'type' => 'select_attribute',
        ]);
        self::assertEquals('Country', $selectField->toArray()['name']);
        self::assertEquals('country', $selectField->toArray()['code']);
        self::assertEquals('select_attribute', $selectField->toArray()['type']);
    }
}
