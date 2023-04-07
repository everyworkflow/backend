<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\EavBundle\Tests\Unit\Attribute;

use EveryWorkflow\DataFormBundle\Factory\FormFieldFactory;
use EveryWorkflow\DataFormBundle\Factory\FormFieldFactoryInterface;
use EveryWorkflow\EavBundle\Factory\AttributeFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AttributeTypeTest extends KernelTestCase
{
    protected FormFieldFactoryInterface $formFieldFactory;
    protected AttributeFactory $attributeFactory;

    protected function setUp(): void
    {
        parent::setUp();

        $container = self::getContainer();

        $this->formFieldFactory = $container->get(FormFieldFactory::class);
        $this->attributeFactory = $container->get(AttributeFactory::class);
    }

    public function testTextAttribute(): void
    {
        self::bootKernel();

        $textField = $this->attributeFactory->createAttribute([
            'name' => 'First name',
            'code' => 'first_name',
        ]);
        $this->assertEquals('First name', $textField->toArray()['name']);
        $this->assertEquals('first_name', $textField->toArray()['code']);
        $this->assertEquals('text_attribute', $textField->toArray()['type']);
    }

    public function testLongTextAttribute(): void
    {
        self::bootKernel();

        $textAreaField = $this->attributeFactory->createAttribute([
            'name' => 'Description',
            'code' => 'description',
            'type' => 'long_text_attribute',
        ]);
        $this->assertEquals('Description', $textAreaField->toArray()['name']);
        $this->assertEquals('description', $textAreaField->toArray()['code']);
        $this->assertEquals('long_text_attribute', $textAreaField->toArray()['type']);
    }

    public function testSelectAttribute(): void
    {
        self::bootKernel();

        $selectField = $this->attributeFactory->createAttribute([
            'name' => 'Country',
            'code' => 'country',
            'type' => 'select_attribute',
        ]);
        $this->assertEquals('Country', $selectField->toArray()['name']);
        $this->assertEquals('country', $selectField->toArray()['code']);
        $this->assertEquals('select_attribute', $selectField->toArray()['type']);
    }
}
