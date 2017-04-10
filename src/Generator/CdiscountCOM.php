<?php

namespace ElasticExportCdiscountCOM\Generator;

use ElasticExport\Helper\ElasticExportCoreHelper;
use ElasticExportCdiscountCOM\Helper\AttributeHelper;
use ElasticExportCdiscountCOM\Helper\PropertyHelper;
use ElasticExportCdiscountCOM\Helper\StockHelper;
use Plenty\Modules\DataExchange\Contracts\CSVPluginGenerator;
use Plenty\Modules\Helper\Models\KeyValue;
use Plenty\Modules\Helper\Services\ArrayHelper;
use Plenty\Modules\Item\Attribute\Contracts\AttributeValueNameRepositoryContract;
use Plenty\Modules\Item\Attribute\Models\AttributeValueName;
use Plenty\Modules\Item\Property\Contracts\PropertySelectionRepositoryContract;
use Plenty\Modules\Item\Search\Contracts\VariationElasticSearchScrollRepositoryContract;
use Plenty\Modules\StockManagement\Stock\Contracts\StockRepositoryContract;
use Plenty\Plugin\Log\Loggable;

class CdiscountCOM extends CSVPluginGenerator
{
    use Loggable;

    const CDISCOUNT_COM = 143.00;
    const CHARACTER_TYPE_DESCRIPTION				    =   'description';
    const CHARACTER_TYPE_GENDER                         =   'gender';
    const CHARACTER_TYPE_TYPE_OF_PUBLIC                 =   'type_of_public';
    const CHARACTER_TYPE_SPORTS                         =   'sports';
    const CHARACTER_TYPE_WARNINGS                       =   'warnings';
    const CHARACTER_TYPE_COMMENT                        =   'comment';
    const CHARACTER_TYPE_MAIN_COLOR                     =   'main_color';
    const CHARACTER_TYPE_MARKETING_DESCRIPTION          =   'marketing_description';
    const CHARACTER_TYPE_MARKETING_COLOR                =   'marketing_color';
    const CHARACTER_TYPE_SIZE                           =   'size';

    /**
     * @var ElasticExportCoreHelper $elasticExportHelper
     */
    private $elasticExportHelper;

    /**
     * @var ArrayHelper
     */
    private $arrayHelper;

    /**
     * AttributeValueNameRepositoryContract $attributeValueNameRepository
     */
    private $attributeValueNameRepository;

    /**
     * PropertySelectionRepositoryContract $propertySelectionRepository
     */
    private $propertySelectionRepository;

    /**
     * @var array $idlVariations
     */
    private $idlVariations = array();

    /**
     * @var array
     */
    private $propertyHelper = array();

    /**
     * @var array
     */
    private $attributeHelper = array();

    /**
     * @var array
     */
    private $stockHelper = array();

    /**
     * CdiscountCOM constructor.
     * @param ArrayHelper $arrayHelper
     * @param AttributeValueNameRepositoryContract $attributeValueNameRepository
     * @param PropertySelectionRepositoryContract $propertySelectionRepository
     * @param PropertyHelper $propertyHelper
     * @param AttributeHelper $attributeHelper
     * @param StockHelper $stockHelper
     */
    public function __construct(
        ArrayHelper $arrayHelper,
        AttributeValueNameRepositoryContract $attributeValueNameRepository,
        PropertySelectionRepositoryContract $propertySelectionRepository,
        PropertyHelper $propertyHelper,
        AttributeHelper $attributeHelper,
        StockHelper $stockHelper
    )
    {
        $this->arrayHelper = $arrayHelper;
        $this->attributeValueNameRepository = $attributeValueNameRepository;
        $this->propertySelectionRepository = $propertySelectionRepository;
        $this->propertyHelper = $propertyHelper;
        $this->attributeHelper = $attributeHelper;
        $this->stockHelper = $stockHelper;
    }

    /**
     * @param VariationElasticSearchScrollRepositoryContract $elasticSearch
     * @param array $formatSettings
     * @param array $filter
     */
    protected function generatePluginContent($elasticSearch, array $formatSettings = [], array $filter = [])
    {
        $this->elasticExportHelper = pluginApp(ElasticExportCoreHelper::class);
        $settings = $this->arrayHelper->buildMapFromObjectList($formatSettings, 'key', 'value');

        $this->setDelimiter(";");

        $this->addCSVContent([
            // Required data for variations - but important for the sellers, should come first
            'Sku parent',

            // Mandatory data
            'Your reference',
            'EAN',
            'Brand',
            'Nature of product',
            'Category code',
            'Basket short wording',
            'Basket long wording',
            'Product description',
            'Picture 1 (jpeg)',

            // Required data for variations
            'Size',
            'Marketing color',

            // Optional data
            'Marketing description',
            'Picture 2 (jpeg)',
            'Picture 3 (jpeg)',
            'Picture 4 (jpeg)',
            'ISBN / GTIN',
            'MFPN',
            'Length ',
            'Width ',
            'Height ',
            'Weight ',


            // Specific data
            'Main color',
            'Gender',
            'Type of public',
            'Sports',
            'Comment'
        ]);

        if($elasticSearch instanceof VariationElasticSearchScrollRepositoryContract)
        {
            $limitReached = false;
            $lines = 0;
            do
            {
                if($limitReached === true)
                {
                    break;
                }

                $resultList = $elasticSearch->execute();

                foreach($resultList['documents'] as $variation)
                {
                    if($lines == $filter['limit'])
                    {
                        $limitReached = true;
                        break;
                    }
                    try
                    {
                        if($this->stockHelper->isFilteredByStock($variation, $filter) === true)
                        {
                            continue;
                        }
                        $this->buildRow($variation, $settings);
                        $lines = $lines +1;
                    }
                    catch(\Throwable $throwable)
                    {
                        $this->getLogger(__METHOD__)->error('ElasticExportCdiscountCOM::logs.fillRowError', [
                            'Error message ' => $throwable->getMessage(),
                            'Error line'    => $throwable->getLine(),
                            'VariationId'   => $variation['id']
                        ]);
                    }
                }
            }while($elasticSearch->hasNext());
        }
    }

    private function buildRow($variation, $settings)
    {
        $variationAttributes = $this->attributeHelper->getVariationAttributes($variation, $settings);

        if(count($variationAttributes['color']) > 0)
        {
            $color = $variationAttributes['color'];
        }
        elseif(strlen($this->propertyHelper->getProperty($variation, $settings, self::CHARACTER_TYPE_MARKETING_COLOR)))
        {
            $color = $this->propertyHelper->getProperty($variation, $settings, self::CHARACTER_TYPE_MARKETING_COLOR);
        }
        else
        {
            $color = '';
        }

        if(count($variationAttributes['size']) > 0)
        {
            $size = $variationAttributes['size'];
        }
        elseif(strlen($this->propertyHelper->getProperty($variation, $settings, self::CHARACTER_TYPE_SIZE)))
        {
            $size = $this->propertyHelper->getProperty($variation, $settings, self::CHARACTER_TYPE_SIZE);
        }
        else
        {
            $size = '';
        }


        $lengthCm = $variation['data']['variation']['lengthMM'] / 10;
        $widthCm = $variation['data']['variation']['widthMM'] / 10;
        $heightCm = $variation['data']['variation']['heightMM'] / 10;
        $weightKg = $variation['data']['variation']['weightG'] / 1000;

        $data = [
            // Required data for variations - but important for the sellers, should come first
            'Sku parent'                            =>  $variation['data']['item']['id'],

            // Mandatory data
            'Your reference'                        =>  $variation['data']['skus']['sku'],
            'EAN'                                   =>  $this->elasticExportHelper->getBarcodeByType($variation, $settings->get('barcode')),
            'Brand'                                 =>  $this->elasticExportHelper->getExternalManufacturerName((int)$variation['data']['item']['manufacturer']['id']),
            'Nature of product'                     =>  strlen($color) || strlen($size) ? 'variante' : 'standard',
            'Category code'                         =>  $variation['data']['defaultCategories'][0]['id'],
            'Basket short wording'                  =>  $this->elasticExportHelper->getName($variation, $settings, 256),
            'Basket long wording'                   =>  $variation['data']['texts'][0]['shortDescription'],
            'Product description'                   =>  $this->getDescription($variation, $settings),
            'Picture 1 (jpeg)'                      =>  $this->getImageByNumber($variation, $settings, 1),

            // Required data for variations
            'Size'                                  =>  $size,
            'Marketing color'                       =>  $color,

            // Optional data
            'Marketing description'                 =>  $this->propertyHelper->getProperty($variation, $settings, self::CHARACTER_TYPE_MARKETING_DESCRIPTION),
            'Picture 2 (jpeg)'                      =>  $this->getImageByNumber($variation, $settings, 2),
            'Picture 3 (jpeg)'                      =>  $this->getImageByNumber($variation, $settings, 3),
            'Picture 4 (jpeg)'                      =>  $this->getImageByNumber($variation, $settings, 4),
            'ISBN / GTIN'                           =>  $this->elasticExportHelper->getBarcodeByType($variation, ElasticExportCoreHelper::BARCODE_ISBN),
            'MFPN'                                  =>  $variation['data']['variation']['model'],
            'Length'                                =>  $lengthCm,
            'Width'                                 =>  $widthCm,
            'Height'                                =>  $heightCm,
            'Weight'                                =>  $weightKg,



            // Specific data
            'Main color'                            =>  $this->propertyHelper->getProperty($variation, $settings, self::CHARACTER_TYPE_MAIN_COLOR),
            'Gender'                                =>  $this->propertyHelper->getProperty($variation, $settings, self::CHARACTER_TYPE_GENDER),
            'Type of public'                        =>  $this->propertyHelper->getProperty($variation, $settings, self::CHARACTER_TYPE_TYPE_OF_PUBLIC),
            'Sports'                                =>  $this->propertyHelper->getProperty($variation, $settings, self::CHARACTER_TYPE_SPORTS),
            'Comment'                               =>  $this->propertyHelper->getProperty($variation, $settings, self::CHARACTER_TYPE_COMMENT)
        ];

        $this->addCSVContent(array_values($data));
    }

    /**
     * Get item description.
     * @param array $item
     * @param KeyValue $settings
     * @return string
     */
    private function getDescription($item, KeyValue $settings):string
    {
        $description = $this->elasticExportHelper->getItemCharacterByBackendName($this->idlVariations[$item['id']], $settings, self::CHARACTER_TYPE_DESCRIPTION);

        if (strlen($description) <= 0)
        {
            $description = $this->elasticExportHelper->getDescription($item, $settings, 5000);
        }

        return $description;
    }

    /**
     * @param array $item
     * @param KeyValue $settings
     * @param int $number
     * @return string
     */
    private function getImageByNumber($item, KeyValue $settings, int $number):string
    {
        $imageList = $this->elasticExportHelper->getImageList($item, $settings);

        if(count($imageList) > 0 && array_key_exists($number, $imageList))
        {
            return $imageList[$number];
        }
        else
        {
            return '';
        }
    }
}