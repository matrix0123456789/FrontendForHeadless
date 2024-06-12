<?php

namespace ExternalData\Ajax;

use Common\PageAjaxController;
use ExternalData\BussinesLogic\ExternalData;

class ExternalDataAjax extends PageAjaxController
{
    public function getTable($config)
    {
        return (new ExternalData())->getTable($config);
    }
    public function insert(string $objectName, $object)
    {
        dump(1);
        (new ExternalData())->insert($objectName, $object);
    }
}
