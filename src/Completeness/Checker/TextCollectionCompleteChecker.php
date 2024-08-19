<?php

namespace Pim\Bundle\ExtendedAttributeTypeBundle\Completeness\Checker;

use Akeneo\Channel\Infrastructure\Component\Model\ChannelInterface;
use Akeneo\Channel\Infrastructure\Component\Model\LocaleInterface;
use Pim\Bundle\ExtendedAttributeTypeBundle\AttributeType\ExtendedAttributeTypes;

/**
 * @author    JM Leroux <jean-marie.leroux@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class TextCollectionCompleteChecker
{
    /**
     * {@inheritdoc}
     */
    public function isComplete(
        $value,
        ChannelInterface $channel = null,
        LocaleInterface $locale = null
    ) {
        if (null !== $value->getScope() && $channel->getCode() !== $value->getScope()) {
            return false;
        }

        if (null !== $value->getLocale() && $locale->getCode() !== $value->getLocale()) {
            return false;
        }

        $collection = $value->getData();

        return null !== $collection && count($collection) > 0;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsValue(
        $value,
        ChannelInterface $channel,
        LocaleInterface $locale
    ) {
        return ExtendedAttributeTypes::TEXT_COLLECTION === $value->getAttribute()->getType();
    }

    public function supportedAttributeTypes(): array
    {
        return [ExtendedAttributeTypes::TEXT_COLLECTION];
    }

}
