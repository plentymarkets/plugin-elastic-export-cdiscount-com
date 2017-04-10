<?php

namespace ElasticExportCdiscountCOM\Helper;


use Plenty\Modules\Item\Property\Contracts\PropertyMarketReferenceRepositoryContract;
use Plenty\Modules\Item\Property\Contracts\PropertyNameRepositoryContract;
use Plenty\Modules\Item\Property\Models\PropertyName;
use Plenty\Modules\Helper\Models\KeyValue;

class PropertyHelper
{
    const CDISCOUNT_COM = 143.00;

    /**
     * @var array
     */
    private $itemPropertyCache = [];
    /**
     * @var AttributeHelper
     */
    private $attributeHelper;

    /**
     * PropertyHelper constructor.
     * @param AttributeHelper $attributeHelper
     */
    public function __construct(AttributeHelper $attributeHelper)
    {
        $this->attributeHelper = $attributeHelper;
    }

    /**
     * Get property.
     * @param  array   $item
     * @param  KeyValue $settings
     * @param  string   $property
     * @return string
     */
    public function getProperty($item, KeyValue $settings, string $property):string
    {
        $variationAttributes = $this->attributeHelper->getVariationAttributes($item, $settings);

        if(array_key_exists($property, $variationAttributes))
        {
            return $variationAttributes[$property];
        }

        $itemPropertyList = $this->getItemPropertyList($item);

        if(array_key_exists($property, $itemPropertyList))
        {
            return $itemPropertyList[$property];
        }

        return '';
    }

    /**
     * Returns a list of additional header for the CSV based on
     * the configured properties and builds also the property data for
     * further usage. The properties have to have a configuration for BeezUp.
     *
     * @param array $variation
     * @return array
     */
    private function getItemPropertyList($variation):array
    {
        if(!array_key_exists($variation['data']['item']['id'], $this->itemPropertyCache))
        {
            /**
             * @var PropertyNameRepositoryContract $propertyNameRepository
             */
            $propertyNameRepository = pluginApp(PropertyNameRepositoryContract::class);

            /**
             * @var PropertyMarketReferenceRepositoryContract $propertyMarketReferenceRepository
             */
            $propertyMarketReferenceRepository = pluginApp(PropertyMarketReferenceRepositoryContract::class);

            if(!$propertyNameRepository instanceof PropertyNameRepositoryContract ||
                !$propertyMarketReferenceRepository instanceof PropertyMarketReferenceRepositoryContract)
            {
                return [];
            }

            $list = array();

            foreach($variation['data']['properties'] as $property)
            {
                if(!is_null($property['property']['id']) &&
                    $property['property']['valueType'] != 'file' &&
                    $property['property']['valueType'] != 'empty')
                {
                    $propertyName = $propertyNameRepository->findOne($property['property']['id'], 'de');
                    $propertyMarketReference = $propertyMarketReferenceRepository->findOne($property['property']['id'], self::CDISCOUNT_COM);

                    if(!($propertyName instanceof PropertyName) ||
                        is_null($propertyName) ||
                        is_null($propertyMarketReference) ||
                        $propertyMarketReference->externalComponent == '0'
                    )
                    {
                        continue;
                    }


                    if($property['property']['valueType'] == 'text')
                    {
                        if(is_array($property['texts']))
                        {
                            $list[(string)$propertyMarketReference->externalComponent] = $property['texts'][0]['value'];
                        }
                    }
                    if($property['property']['valueType'] == 'selection')
                    {
                        if(is_array($property['selection']))
                        {
                            $list[(string)$propertyMarketReference->externalComponent] = $property['selection'][0]['name'];
                        }
                    }
                }
            }
            $this->itemPropertyCache[$variation['data']['item']['id']] = $list;
        }
        return $this->itemPropertyCache[$variation['data']['item']['id']];
    }
}