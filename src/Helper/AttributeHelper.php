<?php

namespace ElasticExportCdiscountCOM\Helper;

use Plenty\Modules\Helper\Models\KeyValue;
use Plenty\Modules\Item\Attribute\Contracts\AttributeValueNameRepositoryContract;
use Plenty\Modules\Item\Attribute\Models\AttributeValueName;
use Plenty\Plugin\Log\Loggable;

class AttributeHelper
{
    use Loggable;

    /**
     * @var AttributeValueNameRepositoryContract
     */
    private $attributeValueNameRepositoryContract;

    /**
     * AttributeHelper constructor.
     *
     * @param AttributeValueNameRepositoryContract $attributeValueNameRepositoryContract
     */
    public function __construct(AttributeValueNameRepositoryContract $attributeValueNameRepositoryContract)
    {
        $this->attributeValueNameRepositoryContract = $attributeValueNameRepositoryContract;
    }

    /**
     * Get variation attributes.
     *
     * @param  array   $variation
     * @param  KeyValue $settings
     * @return array<string,string>
     */
    public function getVariationAttributes($variation, KeyValue $settings):array
    {
        $variationAttributes = [];

        foreach($variation['data']['attributes'] as $variationAttribute)
        {
            $attributeValueName = $this->attributeValueNameRepositoryContract->findOne($variationAttribute['valueId'], $settings->get('lang'));

            if($attributeValueName instanceof AttributeValueName)
            {
                if($attributeValueName->attributeValue->attribute->amazonAttribute)
                {
                    $variationAttributes[$attributeValueName->attributeValue->attribute->amazonAttribute][] = $attributeValueName->name;
                }
            }
        }

        return $variationAttributes;
    }
}