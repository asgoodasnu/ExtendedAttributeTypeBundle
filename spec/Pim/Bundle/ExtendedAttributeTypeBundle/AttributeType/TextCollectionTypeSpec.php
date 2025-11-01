<?php

namespace spec\Pim\Bundle\ExtendedAttributeTypeBundle\AttributeType;

use PhpSpec\ObjectBehavior;
use Pim\Bundle\ExtendedAttributeTypeBundle\AttributeType\ExtendedAttributeTypes;

class TextCollectionTypeSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(ExtendedAttributeTypes::BACKEND_TYPE_TEXT_COLLECTION);
    }

    function it_has_a_name()
    {
        $this->getName()->shouldReturn(ExtendedAttributeTypes::TEXT_COLLECTION);
    }
}
