<?php

namespace ElasticExportCdiscountCOM\Generator;

use ElasticExport\Helper\ElasticExportCoreHelper;
use ElasticExportCdiscountCOM\Helper\AttributeHelper;
use ElasticExportCdiscountCOM\Helper\PropertyHelper;
use ElasticExportCdiscountCOM\Helper\StockHelper;
use Plenty\Modules\DataExchange\Contracts\CSVPluginGenerator;
use Plenty\Modules\Helper\Models\KeyValue;
use Plenty\Modules\Helper\Services\ArrayHelper;
use Plenty\Modules\Item\Search\Contracts\VariationElasticSearchScrollRepositoryContract;
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
     * @var PropertyHelper
     */
    private $propertyHelper;

    /**
     * @var AttributeHelper
     */
    private $attributeHelper;

    /**
     * @var StockHelper
     */
    private $stockHelper;

    /**
     * CdiscountCOM constructor.
     * @param ArrayHelper $arrayHelper
     * @param PropertyHelper $propertyHelper
     * @param AttributeHelper $attributeHelper
     * @param StockHelper $stockHelper
     */
    public function __construct(
        ArrayHelper $arrayHelper,
        PropertyHelper $propertyHelper,
        AttributeHelper $attributeHelper,
        StockHelper $stockHelper
    )
    {
        $this->arrayHelper = $arrayHelper;
        $this->propertyHelper = $propertyHelper;
        $this->attributeHelper = $attributeHelper;
        $this->stockHelper = $stockHelper;
    }

    /**
     * Generates and populates the data into the CSV file.
     *
     * @param VariationElasticSearchScrollRepositoryContract $elasticSearch
     * @param array $formatSettings
     * @param array $filter
     */
    protected function generatePluginContent($elasticSearch, array $formatSettings = [], array $filter = [])
    {
        $this->elasticExportHelper = pluginApp(ElasticExportCoreHelper::class);

        $settings = $this->arrayHelper->buildMapFromObjectList($formatSettings, 'key', 'value');

        $this->setDelimiter(";");

        $this->addCSVContent($this->head());

        $startTime = microtime(true);

        if($elasticSearch instanceof VariationElasticSearchScrollRepositoryContract)
        {
            // Initiate the counter for the variations limit
            $limitReached = false;
            $limit = 0;

            do
            {
                if($limitReached === true)
                {
                    break;
                }

                $this->getLogger(__METHOD__)->debug('ElasticExportCdiscountCOM::logs.writtenLines', [
                    'Lines written' => $limit,
                ]);

                $esStartTime = microtime(true);

                // Get the data from Elastic Search
                $resultList = $elasticSearch->execute();

                $this->getLogger(__METHOD__)->debug('ElasticExportCdiscountCOM::logs.esDuration', [
                    'Elastic Search duration' => microtime(true) - $esStartTime,
                ]);

                if(count($resultList['error']) > 0)
                {
                    $this->getLogger(__METHOD__)->error('ElasticExportCdiscountCOM::logs.occurredElasticSearchErrors', [
                        'Error message' => $resultList['error'],
                    ]);

                    break;
                }

                $buildRowsStartTime = microtime(true);

                if(is_array($resultList['documents']) && count($resultList['documents']) > 0)
                {
                    foreach($resultList['documents'] as $variation)
                    {
                        // Stop and set the flag if limit is reached
                        if($limit == $filter['limit'])
                        {
                            $limitReached = true;
                            break;
                        }

                        // If filtered by stock is set and stock is negative, then skip the variation
                        if($this->stockHelper->isFilteredByStock($variation, $filter) === true)
                        {
                            $this->getLogger(__METHOD__)->info('ElasticExportCdiscountCOM::logs.variationNotPartOfExportStock', [
                                'variationId' => (string)$variation['id']
                            ]);

                            continue;
                        }

                        // New line printed in the CSV file
                        $this->buildRow($variation, $settings);

                        // Count the new printed line
                        $limit += 1;
                    }

                    $this->getLogger(__METHOD__)->debug('ElasticExportCdiscountCOM::logs.buildRowsDuration', [
                        'Build rows duration' => microtime(true) - $buildRowsStartTime,
                    ]);
                }

            } while ($elasticSearch->hasNext());
        }

        $this->getLogger(__METHOD__)->debug('ElasticExportCdiscountCOM::logs.fileGenerationDuration', [
            'Whole file generation duration' => microtime(true) - $startTime,
        ]);
    }

    /**
     * Creates the header of the CSV file.
     *
     * @return array
     */
    private function head():array
    {
        return array(
            // Required data for variations
            // important for the sellers, should come first
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
        );
    }

    /**
     * Creates the variation rows and prints them into the CSV file.
     *
     * @param array $variation
     * @param KeyValue $settings
     */
    private function buildRow($variation, KeyValue $settings)
    {
        $this->getLogger(__METHOD__)->debug('ElasticExportCdiscountCOM::logs.variationConstructRow', [
            'Data row duration' => 'Row printing start'
        ]);

        $rowTime = microtime(true);

        try
        {
            // Get color and size attibutes or property
            $colorAndSize = $this->getColorAndSize($variation, $settings);

            // Set dimensions properties
            $lengthCm = $variation['data']['variation']['lengthMM'] / 10;
            $widthCm  = $variation['data']['variation']['widthMM'] / 10;
            $heightCm = $variation['data']['variation']['heightMM'] / 10;
            $weightKg = $variation['data']['variation']['weightG'] / 1000;

            $data = [
                // Required data for variations
                // important for the sellers, should come first
                'Sku parent'                =>  $variation['data']['item']['id'],

                // Mandatory data
                'Your reference'            =>  $this->getSku($variation),
                'EAN'                       =>  $this->elasticExportHelper->getBarcodeByType($variation, $settings->get('barcode')),
                'Brand'                     =>  $this->elasticExportHelper->getExternalManufacturerName((int)$variation['data']['item']['manufacturer']['id']),
                'Nature of product'         =>  strlen($colorAndSize['color']) || strlen($colorAndSize['size']) ? 'variante' : 'standard',
                'Category code'             =>  $variation['data']['defaultCategories'][0]['id'],
                'Basket short wording'      =>  $this->elasticExportHelper->getName($variation, $settings, 256),
                'Basket long wording'       =>  $variation['data']['texts'][0]['shortDescription'],
                'Product description'       =>  $this->getDescription($variation, $settings),
                'Picture 1 (jpeg)'          =>  $this->getImageByNumber($variation, $settings, 0),

                // Required data for variations
                'Size'                      =>  $colorAndSize['size'],
                'Marketing color'           =>  $colorAndSize['color'],

                // Optional data
                'Marketing description'     =>  $this->propertyHelper->getProperty($variation, $settings, self::CHARACTER_TYPE_MARKETING_DESCRIPTION),
                'Picture 2 (jpeg)'          =>  $this->getImageByNumber($variation, $settings, 1),
                'Picture 3 (jpeg)'          =>  $this->getImageByNumber($variation, $settings, 2),
                'Picture 4 (jpeg)'          =>  $this->getImageByNumber($variation, $settings, 3),
                'ISBN / GTIN'               =>  $this->elasticExportHelper->getBarcodeByType($variation, ElasticExportCoreHelper::BARCODE_ISBN),
                'MFPN'                      =>  $variation['data']['variation']['model'],
                'Length'                    =>  $lengthCm,
                'Width'                     =>  $widthCm,
                'Height'                    =>  $heightCm,
                'Weight'                    =>  $weightKg,

                // Specific data
                'Main color'                =>  $this->propertyHelper->getProperty($variation, $settings, self::CHARACTER_TYPE_MAIN_COLOR),
                'Gender'                    =>  $this->propertyHelper->getProperty($variation, $settings, self::CHARACTER_TYPE_GENDER),
                'Type of public'            =>  $this->propertyHelper->getProperty($variation, $settings, self::CHARACTER_TYPE_TYPE_OF_PUBLIC),
                'Sports'                    =>  $this->propertyHelper->getProperty($variation, $settings, self::CHARACTER_TYPE_SPORTS),
                'Comment'                   =>  $this->propertyHelper->getProperty($variation, $settings, self::CHARACTER_TYPE_COMMENT)
            ];

            $this->addCSVContent(array_values($data));

            $this->getLogger(__METHOD__)->debug('ElasticExportCdiscountCOM::logs.variationConstructRowFinished', [
                'Data row duration' => 'Row printing took: ' . (microtime(true) - $rowTime),
            ]);
        }
        catch (\Throwable $throwable)
        {
            $this->getLogger(__METHOD__)->error('ElasticExportCdiscountCOM::logs.fillRowError', [
                'Error message ' => $throwable->getMessage(),
                'Error line'    => $throwable->getLine(),
                'VariationId'   => $variation['id']
            ]);
        }
    }

    /**
     * Get the sku for the variation.
     *
     * @param $variation
     * @return string
     */
    private function getSku($variation):string
    {
        if(isset($variation['data']['skus']) && count($variation['data']['skus']) > 0)
        {
            $sku = array_shift($variation['data']['skus']);
            if(isset($sku) && strlen($sku['sku']) > 0)
            {
                return $sku['sku'];
            }
        }

        return $this->elasticExportHelper->generateSku($variation['id'], self::CDISCOUNT_COM, 0, $variation['id']);
    }

    /**
     * Get color and size for the variation.
     *
     * @param array $variation
     * @param KeyValue $settings
     * @return array
     */
    private function getColorAndSize($variation, KeyValue $settings)
    {
        $color = $size = '';

        $variationAttributes = $this->attributeHelper->getVariationAttributes($variation, $settings);

        if(count($variationAttributes['color']) > 0)
        {
            $color = $variationAttributes['color'];
        }
        elseif(strlen($this->propertyHelper->getProperty($variation, $settings, self::CHARACTER_TYPE_MARKETING_COLOR)))
        {
            $color = $this->propertyHelper->getProperty($variation, $settings, self::CHARACTER_TYPE_MARKETING_COLOR);
        }

        if(count($variationAttributes['size']) > 0)
        {
            $size = $variationAttributes['size'];
        }
        elseif(strlen($this->propertyHelper->getProperty($variation, $settings, self::CHARACTER_TYPE_SIZE)))
        {
            $size = $this->propertyHelper->getProperty($variation, $settings, self::CHARACTER_TYPE_SIZE);
        }

        return array(
            'color' => $color,
            'size'  => $size
        );
    }

    /**
     * Get variation description.
     *
     * @param array $variation
     * @param KeyValue $settings
     * @return string
     */
    private function getDescription($variation, KeyValue $settings):string
    {
        $description = $this->propertyHelper->getProperty($variation, $settings, self::CHARACTER_TYPE_DESCRIPTION);

        if (strlen($description) <= 0)
        {
            $description = $this->elasticExportHelper->getDescription($variation, $settings, 5000);
        }

        return $description;
    }

    /**
     * Get variation image by number.
     *
     * @param array $variation
     * @param KeyValue $settings
     * @param int $number
     * @return string
     */
    private function getImageByNumber($variation, KeyValue $settings, int $number):string
    {
        $imageList = $this->elasticExportHelper->getImageList($variation, $settings);

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