<?php

namespace ElasticExportCdiscountCOM\Helper;

use ElasticExportCdiscountCOM\Generator\CdiscountCOM;
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
						$this->attributeValueCache[$variationAttribute['valueId']]['marketInformation1'] = $attributeValueMap->marketInformation1;

						if(in_array($this->attributeNameCache[$variationAttribute['attributeId']], [CdiscountCOM::CHARACTER_TYPE_COLOR, CdiscountCOM::CHARACTER_TYPE_MARKETING_COLOR]))
						{
							$this->attributeValueCache[$variationAttribute['valueId']]['marketInformation2'] = $attributeValueMap->marketInformation2;
						}
						elseif(!array_key_exists('marketInformation2', $this->attributeValueCache[$variationAttribute['valueId']]))
						{
							$this->attributeValueCache[$variationAttribute['valueId']]['marketInformation2'] = '';
						}
					}
				}
				
				if(array_key_exists($variationAttribute['attributeId'], $this->attributeNameCache) && array_key_exists($variationAttribute['valueId'], $this->attributeValueCache))
				{
					$variationAttributes[$this->attributeNameCache[$variationAttribute['attributeId']]] = $this->attributeValueCache[$variationAttribute['valueId']]['marketInformation1'];

					if(strlen($this->attributeValueCache[$variationAttribute['valueId']]['marketInformation2']))
					{
						$variationAttributes[CdiscountCOM::CHARACTER_TYPE_MAIN_COLOR] = $this->attributeValueCache[$variationAttribute['valueId']]['marketInformation2'];
					}
				}
			}
		}

		return $variationAttributes;
    }
}