<?php

namespace ElasticExportCdiscountCOM\Helper;

use Plenty\Modules\Helper\Models\KeyValue;
use Plenty\Modules\Item\Attribute\Contracts\AttributeMapRepositoryContract;
use Plenty\Modules\Item\Attribute\Contracts\AttributeValueMapRepositoryContract;
use Plenty\Modules\Item\Attribute\Models\AttributeMap;
use Plenty\Modules\Item\Attribute\Models\AttributeValueMap;
use Plenty\Plugin\Log\Loggable;

class AttributeHelper
{
    use Loggable;

    /**
     * @var AttributeValueMapRepositoryContract
     */
    private $attributeValueMapRepository;
	
    /**
	 * @var AttributeMapRepositoryContract
	 */
	private $attributeMapRepository;

	/**
	 * @var array
	 */
	private $attributeNameCache = [];

	/**
	 * @var array
	 */
	private $attributeValueCache = [];

	/**
	 * AttributeHelper constructor.
	 *
	 * @param AttributeValueMapRepositoryContract $attributeValueMapRepository
	 * @param AttributeMapRepositoryContract $attributeMapRepository
	 */
    public function __construct(AttributeValueMapRepositoryContract $attributeValueMapRepository, AttributeMapRepositoryContract $attributeMapRepository)
    {
        $this->attributeValueMapRepository = $attributeValueMapRepository;
		$this->attributeMapRepository = $attributeMapRepository;
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
			if(!is_null($variationAttribute['attributeId']) && !is_null($variationAttribute['valueId']))
			{
				if(!array_key_exists($variationAttribute['attributeId'], $this->attributeNameCache))
				{
					$attributeMap = $this->attributeMapRepository->find($variationAttribute['attributeId'], $settings->get('referrerId'));

					if($attributeMap instanceof AttributeMap)
					{
						$this->attributeNameCache[$variationAttribute['attributeId']] = $attributeMap->name;
					}
				}

				if(!array_key_exists($variationAttribute['valueId'], $this->attributeValueCache))
				{
					$attributeValueMap = $this->attributeValueMapRepository->find($variationAttribute['attributeId'], $variationAttribute['valueId'], $settings->get('referrerId'));

					if($attributeValueMap instanceof AttributeValueMap)
					{
						$this->attributeValueCache[$variationAttribute['valueId']] = $attributeValueMap->marketInformation1;
					}
				}
				
				if(array_key_exists($variationAttribute['attributeId'], $this->attributeNameCache) && array_key_exists($variationAttribute['valueId'], $this->attributeValueCache))
				{
					$variationAttributes[$this->attributeNameCache[$variationAttribute['attributeId']]] = $this->attributeValueCache[$variationAttribute['valueId']];
				}
			}
		}

		return $variationAttributes;
    }
}