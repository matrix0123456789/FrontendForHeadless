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
        (new ExternalData())->insert($objectName, $object);
    }
    public function update(string $objectName,string $id, $object)
    {
        (new ExternalData())->update($objectName, $id, $object);
    }
}
