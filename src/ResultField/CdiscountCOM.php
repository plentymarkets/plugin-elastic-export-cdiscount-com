<?php

namespace ElasticExportCdiscountCOM\ResultField;

use Plenty\Modules\DataExchange\Contracts\ResultFields;
use Plenty\Modules\DataExchange\Models\FormatSetting;
use Plenty\Modules\Helper\Services\ArrayHelper;
use Plenty\Modules\Item\Search\Mutators\ImageMutator;
use Plenty\Modules\Cloud\ElasticSearch\Lib\Source\Mutator\BuiltIn\LanguageMutator;
use Plenty\Modules\Item\Search\Mutators\KeyMutator;
use Plenty\Modules\Item\Search\Mutators\SkuMutator;
use Plenty\Modules\Item\Search\Mutators\DefaultCategoryMutator;

class CdiscountCOM extends ResultFields
{
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

        $reference = $settings->get('referrerId') ? $settings->get('referrerId') : self::CDISCOUNT_COM;

        $itemDescriptionFields = ['texts.urlPath'];

        switch($settings->get('nameId'))
        {
            case 1:
                $itemDescriptionFields[] = 'texts.name1';
                break;
            case 2:
                $itemDescriptionFields[] = 'texts.name2';
                break;
            case 3:
                $itemDescriptionFields[] = 'texts.name3';
                break;
            default:
                $itemDescriptionFields[] = 'texts.name1';
                break;
        }

        $itemDescriptionFields = array_merge($itemDescriptionFields, ['texts.shortDescription', 'texts.description', 'texts.technicalData']);

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
         * @var DefaultCategoryMutator $defaultCategoryMutator
         */
        $defaultCategoryMutator = pluginApp(DefaultCategoryMutator::class);
        if($defaultCategoryMutator instanceof DefaultCategoryMutator)
        {
            $defaultCategoryMutator->setPlentyId($settings->get('plentyId'));
        }

        $fields = [
            [
                //item
                'item.id',
                'item.manufacturer.id',

                //variation
                'id',
                'variation.model',
                'variation.lengthMM',
                'variation.heightMM',
                'variation.weightG',
                'variation.widthMM',
                'variation.stockLimitation',

                //images
                'images.item.urlMiddle',
                'images.item.urlPreview',
                'images.item.urlSecondPreview',
                'images.item.url',
                'images.item.path',
                'images.item.position',

                'images.variation.urlMiddle',
                'images.variation.urlPreview',
                'images.variation.urlSecondPreview',
                'images.variation.url',
                'images.variation.path',
                'images.variation.position',

                //unit
                'unit.content',
                'unit.id',

                //skus
                'skus.sku',

                //defaultCategories
                'defaultCategories.id',

                //barcodes
                'barcodes.code',
                'barcodes.id',
                'barcodes.type',

                //attributes
                'attributes.valueId',

                //properties
                'properties.property.id',
                'properties.property.valueType',
                'properties.selection.name',
                'properties.texts.value'
            ],

            [
                $languageMutator,
                $skuMutator,
                $keyMutator,
                $defaultCategoryMutator
            ],
        ];

        if($reference != -1)
        {
            $fields[1][] = $imageMutator;
        }

        foreach($itemDescriptionFields as $itemDescriptionField)
        {
            $fields[0][] = $itemDescriptionField;
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