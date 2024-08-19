<?php

namespace Pim\Bundle\ExtendedAttributeTypeBundle\Normalizer\Flat;

use Pim\Bundle\ExtendedAttributeTypeBundle\AttributeType\TextCollectionType;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 * Denormalize flat text collection:
 *    before: $data = 'foo,bar,baz'
 *    after:  $data = ['foo', 'bar', 'baz']
 *
 * @author    JM Leroux <jean-marie.leroux@akeneo.com>
 * @copyright 2017 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @method array getSupportedTypes(?string $format)
 */
class TextCollectionDenormalizerFlat implements DenormalizerInterface
{
    use DenormalizerAwareTrait;

    /**
     * {@inheritdoc}
     */
    public function denormalize($data, string $type, ?string $format = null, array $context = [])
    {
        $data = ('' === $data) ? null : $data;

        if (null !== $data) {
            $data = explode(TextCollectionType::FLAT_SEPARATOR, $data);
        }

        return $data;
    }

    public function supportsDenormalization(mixed $data, string $type, ?string $format = null)
    {
        return true;
    }
}
