<?php

namespace ElasticExportCdiscountCOM;

use Plenty\Modules\DataExchange\Services\ExportPresetContainer;
use Plenty\Plugin\DataExchangeServiceProvider;

class ElasticExportCdiscountCOMServiceProvider extends DataExchangeServiceProvider
{
    public function register()
    {

    }

    public function exports(ExportPresetContainer $container)
    {
        $container->add(
            'CdiscountCOM-Plugin',
            'ElasticExportCdiscountCOM\ResultField\CdiscountCOM',
            'ElasticExportCdiscountCOM\Generator\CdiscountCOM',
            '',
            true
        );
    }
}