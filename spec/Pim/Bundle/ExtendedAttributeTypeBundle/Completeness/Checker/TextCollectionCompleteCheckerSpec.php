<?php

namespace spec\Pim\Bundle\ExtendedAttributeTypeBundle\Completeness\Checker;

use PhpSpec\ObjectBehavior;
use Pim\Bundle\ExtendedAttributeTypeBundle\AttributeType\ExtendedAttributeTypes;
use Akeneo\Pim\Structure\Component\Model\AttributeInterface;
use Akeneo\Channel\Component\Model\ChannelInterface;
use Akeneo\Channel\Component\Model\LocaleInterface;
use Akeneo\Channel\Component\Model\ValueInterface;

class TextCollectionCompleteCheckerSpec extends ObjectBehavior
{
    function it_check_supported_types(
        ValueInterface $value,
        AttributeInterface $attribute,
        ChannelInterface $channel,
        LocaleInterface $locale
    ) {
        $value->getAttribute()->willReturn($attribute);
        $attribute->getType()->willReturn(ExtendedAttributeTypes::TEXT_COLLECTION);
        $this->supportsValue($value, $channel, $locale)->shouldReturn(true);

        $attribute->getType()->willReturn('any_other_type');
        $this->supportsValue($value, $channel, $locale)->shouldReturn(false);
    }

    function it_check_completeness(
        ValueInterface $value,
        ChannelInterface $channel,
        LocaleInterface $locale
    ) {
        $value->getScope()->willReturn(null);
        $value->getLocale()->willReturn(null);
        $value->getData()->willReturn(['foo']);
        $this->isComplete($value, $channel, $locale)->shouldReturn(true);

        $value->getData()->willReturn([]);
        $this->isComplete($value, $channel, $locale)->shouldReturn(false);
    }
}
