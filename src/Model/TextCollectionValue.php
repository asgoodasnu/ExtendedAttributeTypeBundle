<?php

namespace Pim\Bundle\ExtendedAttributeTypeBundle\Model;

use Akeneo\Pim\Enrichment\Component\Product\Model\AbstractValue;
use Akeneo\Pim\Structure\Component\Model\AttributeInterface;
use Akeneo\Pim\Enrichment\Component\Product\Model\ValueInterface;
use Akeneo\Pim\Structure\Component\Query\PublicApi\AttributeType\Attribute;

/**
 * Product value for TextCollection atribute type
 *
 * @author    JM Leroux <jean-marie.leroux@akeneo.com>
 * @copyright 2017 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class TextCollectionValue extends AbstractValue implements ValueInterface
{
    /** @var string[] */
    protected $data;

    /**
     * @param mixed              $data
     */
    public function __construct(Attribute $attribute, ?string $scopeCode, ?string $localeCode, $data)
    {
        parent::__construct($attribute->code(), $data, $scopeCode, $localeCode);
    }

    /**
     * @return string[]
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param string $item
     */
    public function removeItem(string $item)
    {
        $data = array_filter($this->data, function ($value) use ($item) {
            return $value !== $item;
        });
        $this->data = array_values($data);
    }

    /**
     * {@inheritdoc}
     */
    public function __toString(): string
    {
        return implode(', ', $this->data);
    }

    public function isEqual(ValueInterface $value): bool
    {
        return $this->__toString() === $value->__toString();
    }
}
