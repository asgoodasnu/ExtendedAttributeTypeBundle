<?php

namespace spec\Pim\Bundle\ExtendedAttributeTypeBundle\Completeness\Checker;

use PhpSpec\ObjectBehavior;
use Pim\Bundle\ExtendedAttributeTypeBundle\AttributeType\ExtendedAttributeTypes;
use Akeneo\Channel\Infrastructure\Component\Model\ChannelInterface;
use Akeneo\Channel\Infrastructure\Component\Model\LocaleInterface;
use Akeneo\Pim\Enrichment\Component\Product\Model\ValueInterface;

class TextCollectionCompleteCheckerSpec extends ObjectBehavior
{
    function it_check_supported_types(
        ValueInterface $value,
        ChannelInterface $channel,
        LocaleInterface $locale
    ) {
        $value->getAttributeCode()->willReturn(ExtendedAttributeTypes::TEXT_COLLECTION);
        $this->supportsValue($value, $channel, $locale)->shouldReturn(true);

        $value->getAttributeCode()->willReturn('any_other_type');
        $this->supportsValue($value, $channel, $locale)->shouldReturn(false);
    }

    function it_check_completeness(
        ValueInterface $value,
        ChannelInterface $channel,
        LocaleInterface $locale
    ) {
        $value->getScopeCode()->willReturn(null);
        $value->getLocaleCode()->willReturn(null);
        $value->getData()->willReturn(['foo']);
        $this->isComplete($value, $channel, $locale)->shouldReturn(true);

        $value->getData()->willReturn([]);
        $this->isComplete($value, $channel, $locale)->shouldReturn(false);
    }
}
