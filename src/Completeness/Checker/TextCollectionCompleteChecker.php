<?php

namespace Pim\Bundle\ExtendedAttributeTypeBundle\Completeness\Checker;

use Akeneo\Channel\Infrastructure\Component\Model\ChannelInterface;
use Akeneo\Channel\Infrastructure\Component\Model\LocaleInterface;
use Akeneo\Pim\Enrichment\Component\Product\Model\ValueInterface;
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
        ValueInterface $value,
        ChannelInterface $channel = null,
        LocaleInterface $locale = null
    ): bool {
        if (null !== $value->getScopeCode() && $channel->getCode() !== $value->getScopeCode()) {
            return false;
        }

        if (null !== $value->getLocaleCode() && $locale->getCode() !== $value->getLocaleCode()) {
            return false;
        }

        $collection = $value->getData();

        return null !== $collection && count($collection) > 0;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsValue(
        ValueInterface $value,
        ChannelInterface $channel,
        LocaleInterface $locale
    ): bool {
        return ExtendedAttributeTypes::TEXT_COLLECTION === $value->getAttributeCode();
    }

    public function supportedAttributeTypes(): array
    {
        return [ExtendedAttributeTypes::TEXT_COLLECTION];
    }

}
