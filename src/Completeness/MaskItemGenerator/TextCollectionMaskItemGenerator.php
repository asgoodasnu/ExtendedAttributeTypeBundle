<?php

declare(strict_types=1);

namespace Pim\Bundle\ExtendedAttributeTypeBundle\Completeness\MaskItemGenerator;

use Akeneo\Pim\Enrichment\Component\Product\Completeness\MaskItemGenerator\MaskItemGeneratorForAttributeType;
use Akeneo\Pim\Structure\Component\AttributeTypes;
use Pim\Bundle\ExtendedAttributeTypeBundle\AttributeType\ExtendedAttributeTypes;

class TextCollectionMaskItemGenerator implements MaskItemGeneratorForAttributeType
{

    public function forRawValue(string $attributeCode, string $channelCode, string $localeCode, $value): array
    {
        if (
            !isset($value['amount']) ||
            '' === $value['amount'] ||
            !isset($value['unit']) ||
            '' === $value['unit'] ||
            !isset($value['base_data']) ||
            '' === $value['base_data'] ||
            !isset($value['base_unit']) ||
            '' === $value['base_unit']
        ) {
            return [];
        }

        return [
            sprintf('%s-%s-%s',
                    $attributeCode,
                    $channelCode,
                    $localeCode
            )
        ];
    }

    public function supportedAttributeTypes(): array
    {
        return [ExtendedAttributeTypes::TEXT_COLLECTION];
    }

}

