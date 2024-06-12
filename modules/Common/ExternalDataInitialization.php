<?php

namespace Common;

use ExternalData\BussinesLogic\ExternalData;
use ExternalData\BussinesLogic\RestApiDataSource;

class ExternalDataInitialization
{
    public static function init()
    {
        ExternalData::registerDataSource(new RestApiDataSource('https://localhost:44343/_schema'));
    }
}
