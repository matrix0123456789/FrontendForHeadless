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
    public function add(string $objectName)
    {
        $this->addView('ExternalData', 'ExternalDataEdit', ['type' => 'add']);
    }
    public function add_data(string $objectName)
    {
        $schema = (new ExternalData)->getObjectSchema($objectName);
        return ['schema' => $schema, 'objectName'=>$objectName];
    }
}
