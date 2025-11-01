<?php

namespace spec\Pim\Bundle\ExtendedAttributeTypeBundle\Elasticsearch\Filter\Attribute;

use Akeneo\Pim\Enrichment\Component\Product\Validator\ElasticsearchFilterValidator;
use PhpSpec\ObjectBehavior;
use Akeneo\Pim\Enrichment\Bundle\Elasticsearch\Filter\Attribute\AbstractAttributeFilter;
use Akeneo\Pim\Enrichment\Bundle\Elasticsearch\SearchQueryBuilder;
use Pim\Bundle\ExtendedAttributeTypeBundle\AttributeType\ExtendedAttributeTypes;
use Pim\Bundle\ExtendedAttributeTypeBundle\Elasticsearch\Filter\Attribute\TextCollectionFilter;
use Akeneo\Pim\Structure\Component\AttributeTypes;
use Akeneo\Pim\Enrichment\Component\Product\Exception\InvalidOperatorException;
use Akeneo\Pim\Structure\Component\Model\AttributeInterface;
use Akeneo\Pim\Enrichment\Component\Product\Query\Filter\AttributeFilterInterface;
use Akeneo\Pim\Enrichment\Component\Product\Query\Filter\Operators;
use Prophecy\Argument;

class TextCollectionFilterSpec extends ObjectBehavior
{
    function let(
        ElasticsearchFilterValidator $filterValidator,
        AttributeInterface           $urlList
    ) {
        $this->beConstructedWith(
            $filterValidator,
            [ExtendedAttributeTypes::TEXT_COLLECTION],
            [Operators::CONTAINS, Operators::DOES_NOT_CONTAIN, Operators::IS_EMPTY, Operators::IS_NOT_EMPTY]
        );

        $urlList->getType()->willReturn(ExtendedAttributeTypes::TEXT_COLLECTION);
        $urlList->getBackendType()->willReturn(ExtendedAttributeTypes::BACKEND_TYPE_TEXT_COLLECTION);
        $urlList->getCode()->willReturn('url_list');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(TextCollectionFilter::class);
    }

    function it_is_a_filter()
    {
        $this->shouldImplement(AttributeFilterInterface::class);
        $this->shouldBeAnInstanceOf(AbstractAttributeFilter::class);
    }

    function it_supports_operators()
    {
        $this->getOperators()->shouldReturn(
            [
                'CONTAINS',
                'DOES NOT CONTAIN',
                'EMPTY',
                'NOT EMPTY',
            ]
        );
        $this->supportsOperator('CONTAINS')->shouldReturn(true);
        $this->supportsOperator('FAKE')->shouldReturn(false);
    }

    function it_supports_text_collection_attributes
    (
        AttributeInterface $urlList,
        AttributeInterface $textAttribute
    ) {
        $this->getAttributeTypes()->shouldReturn([ExtendedAttributeTypes::TEXT_COLLECTION]);

        $textAttribute->getType()->willReturn(AttributeTypes::TEXT);
        $this->supportsAttribute($textAttribute)->shouldReturn(false);
        $this->supportsAttribute($urlList)->shouldReturn(true);
    }

    function it_throws_an_exception_on_uninitialized_query_builder(AttributeInterface $urlList)
    {
        $this->shouldThrow(new \LogicException('The search query builder is not initialized in the filter.'))
             ->during(
                 'addAttributeFilter',
                 [
                     $urlList,
                     Argument::any(),
                     Argument::cetera(),
                 ]
             );
    }

    function it_throws_an_exception_on_unsupported_operator(
        SearchQueryBuilder $searchQueryBuilder,
        AttributeInterface $urlList
    ) {
        $this->setQueryBuilder($searchQueryBuilder);
        $operator = Operators::STARTS_WITH;
        $exception = InvalidOperatorException::notSupported($operator, TextCollectionFilter::class);
        $this->shouldThrow($exception)->during(
            'addAttributeFilter',
            [
                $urlList,
                $operator,
                'anystring',
            ]
        );
    }

    function it_adds_a_filter_with_operator_empty(
        ElasticsearchFilterValidator $filterValidator,
        AttributeInterface           $urlList,
        SearchQueryBuilder           $sqb
    ) {
        $filterValidator->validateLocaleForAttribute('url_list', 'en_US')->shouldBeCalled();
        $filterValidator->validateChannelForAttribute('url_list', 'ecommerce')->shouldBeCalled();

        $sqb->addMustNot(
            [
                'exists' => [
                    'field' => 'values.url_list-textCollection.ecommerce.en_US',
                ],
            ]
        )->shouldBeCalled();

        $this->setQueryBuilder($sqb);
        $this->addAttributeFilter($urlList, Operators::IS_EMPTY, null, 'en_US', 'ecommerce', []);
    }

    function it_adds_a_filter_with_operator_is_not_empty(
        ElasticsearchFilterValidator $filterValidator,
        AttributeInterface           $urlList,
        SearchQueryBuilder           $sqb
    ) {
        $filterValidator->validateLocaleForAttribute('url_list', 'en_US')->shouldBeCalled();
        $filterValidator->validateChannelForAttribute('url_list', 'ecommerce')->shouldBeCalled();

        $sqb->addFilter(
            [
                'exists' => [
                    'field' => 'values.url_list-textCollection.ecommerce.en_US',
                ],
            ]
        )->shouldBeCalled();

        $this->setQueryBuilder($sqb);
        $this->addAttributeFilter($urlList, Operators::IS_NOT_EMPTY, null, 'en_US', 'ecommerce', []);
    }

    function it_adds_a_filter_with_operator_contains(
        ElasticsearchFilterValidator $filterValidator,
        AttributeInterface           $urlList,
        SearchQueryBuilder           $sqb
    ) {
        $filterValidator->validateLocaleForAttribute('url_list', 'en_US')->shouldBeCalledOnce();
        $filterValidator->validateChannelForAttribute('url_list', 'ecommerce')->shouldBeCalledOnce();

        $sqb->addFilter(
            [
                'term' => [
                    'values.url_list-textCollection.ecommerce.en_US' => 'http://fake-domain.null',
                ],
            ]
        )->shouldBeCalled();

        $this->setQueryBuilder($sqb);
        $this->addAttributeFilter($urlList, Operators::CONTAINS, 'http://fake-domain.null', 'en_US', 'ecommerce', []);
    }

    function it_adds_a_filter_with_operator_does_not_contain(
        ElasticsearchFilterValidator $filterValidator,
        AttributeInterface           $urlList,
        SearchQueryBuilder           $sqb
    ) {
        $filterValidator->validateLocaleForAttribute('url_list', 'en_US')->shouldBeCalled();
        $filterValidator->validateChannelForAttribute('url_list', 'ecommerce')->shouldBeCalled();

        $sqb->addFilter([
                'exists' => [
                    'field' => 'values.url_list-textCollection.ecommerce.en_US',
                ],
            ]
        )->shouldBeCalled();

        $sqb->addMustNot(
            [
                'term' => [
                    'values.url_list-textCollection.ecommerce.en_US' => 'http://fake-domain.null',
                ],
            ]
        )->shouldBeCalled();

        $this->setQueryBuilder($sqb);
        $this->addAttributeFilter($urlList, Operators::DOES_NOT_CONTAIN, 'http://fake-domain.null', 'en_US', 'ecommerce', []);
    }
}
