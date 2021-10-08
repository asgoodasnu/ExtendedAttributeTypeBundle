<?php

namespace Pim\Bundle\ExtendedAttributeTypeBundle\Factory\Value;

use Akeneo\Pim\Enrichment\Component\Product\Factory\Value\ValueFactory;
use Akeneo\Tool\Component\StorageUtils\Exception\InvalidPropertyTypeException;
use Akeneo\Pim\Structure\Component\Query\PublicApi\AttributeType\Attribute;
use Akeneo\Pim\Enrichment\Component\Product\Model\ValueInterface;
use Pim\Bundle\ExtendedAttributeTypeBundle\AttributeType\ExtendedAttributeTypes;

/**
 * Factory that creates simple product values (text, textarea and number).
 *
 * @author    JM Leroux <jean-marie.leroux@akeneo.com>
 * @copyright 2017 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class TextCollectionValueFactory implements ValueFactory
{
    const BOOLEAN = 'pim_catalog_boolean';

    /** @var string */
    protected $productValueClass;

    /** @var string */
    protected $supportedAttributeTypes;

    /**
     * @param string $productValueClass
     * @param string $supportedAttributeTypes
     */
    public function __construct($productValueClass, $supportedAttributeTypes)
    {
        $this->productValueClass = $productValueClass;
        $this->supportedAttributeTypes = $supportedAttributeTypes;
    }

    /**
     * {@inheritdoc}
     */
    public function createByCheckingData(Attribute $attribute, ?string $channelCode, ?string $localeCode, $data): ValueInterface
    {
        $this->checkData($attribute, $data);

        if (null !== $data) {
            $data = $this->convertData($attribute, $data);
        }

        $value = new $this->productValueClass($attribute, $channelCode, $localeCode, $data);

        return $value;
    }

    public function createWithoutCheckingData(Attribute $attribute, ?string $channelCode, ?string $localeCode, $data): ValueInterface
    {
        if (null !== $data) {
            $data = $this->convertData($attribute, $data);
        }

        $value = new $this->productValueClass($attribute, $channelCode, $localeCode, $data);

        return $value;
    }

    /**
     * {@inheritdoc}
     */
    public function supports($attributeType)
    {
        return $attributeType === $this->supportedAttributeTypes;
    }

    public function supportedAttributeType(): string
    {
        return ExtendedAttributeTypes::TEXT_COLLECTION;
    }

    /**
     * @param AttributeInterface $attribute
     * @param mixed              $data
     *
     * @throws InvalidPropertyTypeException
     */
    protected function checkData(Attribute $attribute, $data)
    {
        if (null === $data) {
            return;
        }

        if (!is_array($data)) {
            throw InvalidPropertyTypeException::arrayExpected(
                $attribute->getCode(),
                static::class,
                $data
            );
        }
    }

    /**
     * @param AttributeInterface $attribute
     * @param mixed              $data
     *
     * @return mixed
     */
    protected function convertData(Attribute $attribute, $data)
    {
        if (is_string($data) && '' === trim($data)) {
            $data = null;
        }

        if (self::BOOLEAN === $attribute->type() &&
            (1 === $data || '1' === $data || 0 === $data || '0' === $data)
        ) {
            $data = boolval($data);
        }

        return $data;
    }
}
