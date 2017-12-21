<?php

namespace ElasticExportCdiscountCOM\Generator;

use ElasticExport\Helper\ElasticExportCoreHelper;
use ElasticExport\Helper\ElasticExportPropertyHelper;
use ElasticExport\Helper\ElasticExportStockHelper;
use ElasticExportCdiscountCOM\Helper\AttributeHelper;
use Plenty\Modules\DataExchange\Contracts\CSVPluginGenerator;
use Plenty\Modules\Helper\Models\KeyValue;
use Plenty\Modules\Helper\Services\ArrayHelper;
use Plenty\Modules\Item\Search\Contracts\VariationElasticSearchScrollRepositoryContract;
use Plenty\Plugin\Log\Loggable;

class CdiscountCOM extends CSVPluginGenerator
{
    use Loggable;

    const CDISCOUNT_COM = 143.00;
    const DELIMITER = ";";

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
     * @var AttributeHelper
     */
    private $attributeHelper;

	/**
	 * @var ElasticExportStockHelper $elasticExportStockHelper
	 */
	private $elasticExportStockHelper;

	/**
	 * @var ElasticExportPropertyHelper $elasticExportPropertyHelper
	 */
	private $elasticExportPropertyHelper;

	/**
	 * @var array
	 */
	private $imageCache;

	/**
	 * CdiscountCOM constructor.
	 * @param ArrayHelper $arrayHelper
	 * @param AttributeHelper $attributeHelper
	 */
    public function __construct(
        ArrayHelper $arrayHelper,
        AttributeHelper $attributeHelper
    )
    {
        $this->arrayHelper = $arrayHelper;
        $this->attributeHelper = $attributeHelper;
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
		$this->elasticExportStockHelper = pluginApp(ElasticExportStockHelper::class);
        $this->elasticExportHelper = pluginApp(ElasticExportCoreHelper::class);
        $this->elasticExportPropertyHelper = pluginApp(ElasticExportPropertyHelper::class);

        $settings = $this->arrayHelper->buildMapFromObjectList($formatSettings, 'key', 'value');

        $this->setDelimiter(self::DELIMITER);

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
                        if($this->elasticExportStockHelper->isFilteredByStock($variation, $filter) === true)
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
                'Your reference'            =>  $this->elasticExportHelper->generateSku($variation['id'], self::CDISCOUNT_COM, 0, $variation['data']['skus'][0]['sku']),
                'EAN'                       =>  $this->elasticExportHelper->getBarcodeByType($variation, $settings->get('barcode')),
                'Brand'                     =>  $this->elasticExportHelper->getExternalManufacturerName((int)$variation['data']['item']['manufacturer']['id']),
                'Nature of product'         =>  strlen($colorAndSize['color']) || strlen($colorAndSize['size']) ? 'variante' : 'standard',
                'Category code'             =>  $this->elasticExportHelper->getCategoryMarketplace((int)$variation['data']['defaultCategories'][0]['id'], (int)$settings->get('plentyId'), (int)self::CDISCOUNT_COM),
                'Basket short wording'      =>  $this->elasticExportHelper->getMutatedName($variation, $settings, 256),
                'Basket long wording'       =>  $variation['data']['texts']['shortDescription'],
                'Product description'       =>  $this->getDescription($variation, $settings),
                'Picture 1 (jpeg)'          =>  $this->getImageByNumber($variation, $settings, 0),

                // Required data for variations
                'Size'                      =>  $colorAndSize['size'],
                'Marketing color'           =>  $colorAndSize['color'],

                // Optional data
                'Marketing description'     =>  $this->elasticExportPropertyHelper->getProperty($variation, self::CHARACTER_TYPE_MARKETING_DESCRIPTION, self::CDISCOUNT_COM),
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
                'Main color'                =>  $this->elasticExportPropertyHelper->getProperty($variation, self::CHARACTER_TYPE_MAIN_COLOR, self::CDISCOUNT_COM),
                'Gender'                    =>  $this->elasticExportPropertyHelper->getProperty($variation, self::CHARACTER_TYPE_GENDER, self::CDISCOUNT_COM),
                'Type of public'            =>  $this->elasticExportPropertyHelper->getProperty($variation, self::CHARACTER_TYPE_TYPE_OF_PUBLIC, self::CDISCOUNT_COM),
                'Sports'                    =>  $this->elasticExportPropertyHelper->getProperty($variation, self::CHARACTER_TYPE_SPORTS, self::CDISCOUNT_COM),
                'Comment'                   =>  $this->elasticExportPropertyHelper->getProperty($variation, self::CHARACTER_TYPE_COMMENT, self::CDISCOUNT_COM)
            ];

            $this->addCSVContent(array_values($data));

            unset($this->imageCache[$variation['id']]);

            $this->getLogger(__METHOD__)->debug('ElasticExportCdiscountCOM::logs.variationConstructRowFinished', [
                'Data row duration' => 'Row printing took: ' . (microtime(true) - $rowTime),
            ]);
        }
        catch (\Throwable $throwable)
        {
            $this->getLogger(__METHOD__)->error('ElasticExportCdiscountCOM::logs.fillRowError', [
                'Error message' => $throwable->getMessage(),
                'Error line'    => $throwable->getLine(),
                'VariationId'   => $variation['id']
            ]);
        }
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

        if(array_key_exists('color', $variationAttributes))//count($variationAttributes['color']) > 0)
        {
            $color = $variationAttributes['color'];
        }
        elseif(strlen($this->elasticExportPropertyHelper->getProperty($variation, self::CHARACTER_TYPE_MARKETING_COLOR, self::CDISCOUNT_COM)))
        {
            $color = $this->elasticExportPropertyHelper->getProperty($variation, self::CHARACTER_TYPE_MARKETING_COLOR, self::CDISCOUNT_COM);
        }

        if(array_key_exists('size', $variationAttributes))
        {
            $size = $variationAttributes['size'];
        }
        elseif(strlen($this->elasticExportPropertyHelper->getProperty($variation, self::CHARACTER_TYPE_SIZE, self::CDISCOUNT_COM)))
        {
            $size = $this->elasticExportPropertyHelper->getProperty($variation, self::CHARACTER_TYPE_SIZE, self::CDISCOUNT_COM);
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
        $description = $this->elasticExportPropertyHelper->getProperty($variation, self::CHARACTER_TYPE_DESCRIPTION, self::CDISCOUNT_COM);

        if (strlen($description) <= 0)
        {
            $description = $this->elasticExportHelper->getMutatedDescription($variation, $settings, 5000);
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
		if(array_key_exists($variation['id'], $this->imageCache))
		{
			return $this->returnImagePath($variation, $number);
		}

		$this->imageCache[$variation['id']] = $this->elasticExportHelper->getImageListInOrder($variation, $settings, 4, 'variationImages');

		return $this->returnImagePath($variation, $number);
	}

	/**
	 * @param $variation
	 * @param int $number
	 * @return string
	 */
	private function returnImagePath($variation, int $number)
	{
		if(array_key_exists($number, $this->imageCache[$variation['id']]))
		{
			return $this->imageCache[$variation['id']][$number];
		}
		else
		{
			return '';
		}
	}
}