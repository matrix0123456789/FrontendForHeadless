<?php

namespace ExternalData\Controllers;
use ExternalData\BussinesLogic\ExternalData;

class ExternalDataController extends \Common\PageStandardController
{
    public function list(string $objectName)
    {
        $this->addView('ExternalData', 'ExternalDataList');
    }
    public function list_data(string $objectName)
    {
        dump($objectName);
        $schema = (new ExternalData)->getObjectSchema($objectName);
        return ['schema' => $schema, 'objectName'=>$objectName];
    }
}
