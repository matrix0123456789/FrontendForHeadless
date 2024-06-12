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
}
