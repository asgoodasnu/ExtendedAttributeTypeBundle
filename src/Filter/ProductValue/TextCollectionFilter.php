<?php

namespace Pim\Bundle\ExtendedAttributeTypeBundle\Filter\ProductValue;

use Oro\Bundle\FilterBundle\Form\Type\Filter\FilterType;
use Oro\Bundle\FilterBundle\Form\Type\Filter\TextFilterType;
use Pim\Bundle\ExtendedAttributeTypeBundle\DataGrid\Form\Type\Filter\TextCollectionFilterType;
use Oro\Bundle\FilterBundle\Filter\StringFilter;
use Akeneo\Pim\Enrichment\Component\Product\Query\Filter\Operators;

/**
 * TextCollectionFilter
 *
 * @author    JM Leroux <jean-marie.leroux@akeneo.com>
 * @copyright 2017 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class TextCollectionFilter extends StringFilter
{
    /** @var array */
    protected $operatorTypes = [
        TextFilterType::TYPE_CONTAINS     => Operators::CONTAINS,
        TextFilterType::TYPE_NOT_CONTAINS => Operators::DOES_NOT_CONTAIN,
        FilterType::TYPE_EMPTY            => Operators::IS_EMPTY,
        FilterType::TYPE_NOT_EMPTY        => Operators::IS_NOT_EMPTY,
    ];

    /**
     * {@inheritDoc}
     */
    protected function getFormType()
    {
        return TextCollectionFilterType::class;
    }

    public function getForm()
    {
        return parent::getForm(); // TODO: Change the autogenerated stub
    }
}
