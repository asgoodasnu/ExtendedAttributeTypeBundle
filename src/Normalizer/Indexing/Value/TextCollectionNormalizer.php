<?php

namespace Pim\Bundle\ExtendedAttributeTypeBundle\Normalizer\Indexing\Value;

use Akeneo\Pim\Enrichment\Component\Product\Model\ValueInterface;
use Pim\Bundle\ExtendedAttributeTypeBundle\Model\TextCollectionValue;
use Akeneo\Pim\Enrichment\Component\Product\Normalizer\Indexing\Value\AbstractProductValueNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Normalizer for a options product value
 *
 * @author    JM Leroux <jean-marie.leroux@akeneo.com>
 * @copyright 2017 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class TextCollectionNormalizer extends AbstractProductValueNormalizer implements NormalizerInterface
{
    public const INDEXING_FORMAT_PRODUCT_INDEX = 'indexing_product';
    public const INDEXING_FORMAT_PRODUCT_MODEL_INDEX = 'indexing_product_model';
    public const INDEXING_FORMAT_PRODUCT_AND_MODEL_INDEX = 'indexing_product_and_product_model';

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof TextCollectionValue && (
                $format === self::INDEXING_FORMAT_PRODUCT_INDEX ||
                $format === self::INDEXING_FORMAT_PRODUCT_MODEL_INDEX ||
                $format === self::INDEXING_FORMAT_PRODUCT_AND_MODEL_INDEX
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function getNormalizedData(ValueInterface $value)
    {
        return $value->getData();
    }
}
