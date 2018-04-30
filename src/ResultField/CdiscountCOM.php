<?php

namespace ElasticExportCdiscountCOM\ResultField;

use ElasticExport\DataProvider\ResultFieldDataProvider;
use Plenty\Modules\Cloud\ElasticSearch\Lib\ElasticSearch;
use Plenty\Modules\DataExchange\Contracts\ResultFields;
use Plenty\Modules\DataExchange\Models\FormatSetting;
use Plenty\Modules\Helper\Services\ArrayHelper;
use Plenty\Modules\Item\Search\Mutators\BarcodeMutator;
use Plenty\Modules\Item\Search\Mutators\ImageMutator;
use Plenty\Modules\Cloud\ElasticSearch\Lib\Source\Mutator\BuiltIn\LanguageMutator;
use Plenty\Modules\Item\Search\Mutators\KeyMutator;
use Plenty\Modules\Item\Search\Mutators\SkuMutator;
use Plenty\Modules\Item\Search\Mutators\DefaultCategoryMutator;
use Plenty\Plugin\Log\Loggable;

class CdiscountCOM extends ResultFields
{
	use Loggable;
	
    const CDISCOUNT_COM = 143.00;

    /**
     * @var ArrayHelper
     */
    private $arrayHelper;

    /**
     * CdiscountCOM constructor.
     *
     * @param ArrayHelper $arrayHelper
     */
    public function __construct(ArrayHelper $arrayHelper)
    {
        $this->arrayHelper = $arrayHelper;
    }

    /**
     * Creates the fields set to be retrieved from ElasticSearch.
     *
     * @param array $formatSettings
     * @return array
     */
    public function generateResultFields(array $formatSettings = []):array
    {
        $settings = $this->arrayHelper->buildMapFromObjectList($formatSettings, 'key', 'value');
		$this->setOrderByList([
			'path' => 'item.id',
			'order' => ElasticSearch::SORTING_ORDER_ASC]);
		$reference = $settings->get('referrerId') ? $settings->get('referrerId') : self::CDISCOUNT_COM;

        /**
         * @var ImageMutator $imageMutator
         */
        $imageMutator = pluginApp(ImageMutator::class);
        if($imageMutator instanceof ImageMutator)
        {
            $imageMutator->addMarket($reference);
        }

        /**
         * @var KeyMutator
         */
        $keyMutator = pluginApp(KeyMutator::class);

        if($keyMutator instanceof KeyMutator)
        {
            $keyMutator->setKeyList($this->getKeyList());
            $keyMutator->setNestedKeyList($this->getNestedKeyList());
        }

        /**
         * @var LanguageMutator $languageMutator
         */
        $languageMutator = pluginApp(LanguageMutator::class, [[$settings->get('lang')]]);

        /**
         * @var SkuMutator $skuMutator
         */
        $skuMutator = pluginApp(SkuMutator::class);
        if($skuMutator instanceof SkuMutator)
        {
            $skuMutator->setMarket($reference);
        }

		/**
		 * @var BarcodeMutator $barcodeMutator
		 */
		$barcodeMutator = pluginApp(BarcodeMutator::class);
		if($barcodeMutator instanceof BarcodeMutator)
		{
			$barcodeMutator->addMarket($reference);
		}
		
        /**
         * @var DefaultCategoryMutator $defaultCategoryMutator
         */
        $defaultCategoryMutator = pluginApp(DefaultCategoryMutator::class);
        if($defaultCategoryMutator instanceof DefaultCategoryMutator)
        {
            $defaultCategoryMutator->setPlentyId($settings->get('plentyId'));
        }

		$resultFieldHelper = pluginApp(ResultFieldDataProvider::class);
		if($resultFieldHelper instanceof ResultFieldDataProvider)
		{
			$resultFields = $resultFieldHelper->getResultFields($settings);
		}

		if(isset($resultFields) && is_array($resultFields) && count($resultFields))
		{
			$fields[0] = $resultFields;
			$fields[1] = [
				$languageMutator,
				$skuMutator,
				$defaultCategoryMutator,
				$barcodeMutator,
				$keyMutator
			];

			if($reference != -1)
			{
				$fields[1][] = $imageMutator;
			}
		}
		else
		{
			$this->getLogger(__METHOD__)->critical('ElasticExportCdiscountCOM::log.resultFieldError');
			exit();
		}
		
        return $fields;
    }

    /**
     * Returns the list of keys.
     *
     * @return array
     */
    private function getKeyList()
    {
        $keyList = [
            //item
            'item.id',
            'item.manufacturer.id',

            //variation
            'variation.model',
            'variation.lengthMM',
            'variation.heightMM',
            'variation.weightG',
            'variation.widthMM',
            'variation.stockLimitation',

            //unit
            'unit.content',
            'unit.id',
        ];

        return $keyList;
    }

    /**
     * Returns the list of nested keys.
     *
     * @return mixed
     */
    private function getNestedKeyList()
    {
        $nestedKeyList['keys'] = [
            //images
            'images.item',
            'images.variation',

            //skus
            'skus',

            //texts
            'texts',

            //defaultCategories
            'defaultCategories',

            //barcodes
            'barcodes',

            //attributes
            'attributes',

            //properties
            'properties',
        ];

        $nestedKeyList['nestedKeys'] = [
            //images
            'images.item' => [
                'urlMiddle',
                'urlPreview',
                'urlSecondPreview',
                'url',
                'path',
                'position',
            ],
            'images.variation' => [
                'urlMiddle',
                'urlPreview',
                'urlSecondPreview',
                'url',
                'path',
                'position',
            ],

            //skus
            'skus' => [
                'sku',
            ],

            //texts
            'texts'  => [
                'urlPath',
                'name1',
                'name2',
                'name3',
                'shortDescription',
                'description',
                'technicalData',
            ],

            //defaultCategories
            'defaultCategories' => [
                'id',
            ],

            //barcodes
            'barcodes'  => [
                'code',
                'type',
            ],

            //attributes
            'attributes'   => [
                'valueId',
            ],

            //proprieties
            'properties'    => [
                'property.id',
                'property.valueType',
                'selection.name',
                'texts.value',
            ]
        ];

        return $nestedKeyList;
    }
}