<?php

namespace Pim\Bundle\ExtendedAttributeTypeBundle\Tests\Unit\ArrayConverter\FlatToStandard\Product\ValueConverter;

use PHPUnit\Framework\Attributes\CoversClass;
use Pim\Bundle\ExtendedAttributeTypeBundle\ArrayConverter\FlatToStandard\Product\ValueConverter\TextCollectionConverter;
use PHPUnit\Framework\TestCase;
use Pim\Bundle\ExtendedAttributeTypeBundle\AttributeType\ExtendedAttributeTypes;

#[CoversClass(TextCollectionConverter::class)]
class TextCollectionConverterTest extends TestCase
{
    private TextCollectionConverter $converter;

    public function setUp(): void
    {
        $this->converter = new TextCollectionConverter([ExtendedAttributeTypes::TEXT_COLLECTION]);
    }

    public function testSupportsFieldShouldReturnTrue(): void
    {
        $this->assertTrue($this->converter->supportsField(ExtendedAttributeTypes::TEXT_COLLECTION));
    }

    public function testSupportsFieldShouldReturnFalse(): void
    {
        $this->assertFalse($this->converter->supportsField('unknown_field'));
    }

    public function testConvertShouldReturnCorrectValue(): void
    {
        $this->assertEquals(
            ['item1', 'item2'],
            $this->converter->convert(
                ['type' => ExtendedAttributeTypes::TEXT_COLLECTION],
                'item1,item2'
            )
        );
    }
}
