<?php

namespace ExternalData\Controllers;
use ExternalData\BussinesLogic\ExternalData;

class ExternalDataController extends \Common\PageStandardController
{
    public function index()
    {
        $objectTypes = (new ExternalData)->getObjectTypes();
        $this->addView('ExternalData', 'ExternalData', ['objectTypes' => $objectTypes]);
        $this->pushBreadcrumb(['title' => 'External Data', 'url' => '/ExternalData']);
    }
    public function list(string $objectName)
    {
        $this->addView('ExternalData', 'ExternalDataList', ['objectName' => $objectName]);
        $this->pushBreadcrumb(['title' => 'External Data', 'url' => '/ExternalData']);
        $this->pushBreadcrumb(['title' => $objectName, 'url' => '/ExternalData/'.$objectName]);
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
        $this->pushBreadcrumb(['title' => 'External Data', 'url' => '/ExternalData']);
        $this->pushBreadcrumb(['title' => $objectName, 'url' => '/ExternalData/'.$objectName]);
        $this->pushBreadcrumb(['title' => t('Common.add'), 'url' => '/ExternalData/'.$objectName.'/add']);
    }
    public function add_data(string $objectName)
    {
        $schema = (new ExternalData)->getObjectSchema($objectName);
        return ['schema' => $schema, 'objectName'=>$objectName];
    }

    public function edit(string $objectName, string $id)
    {
        $this->addView('ExternalData', 'ExternalDataEdit', ['type' => 'add']);
        $this->pushBreadcrumb(['title' => 'External Data', 'url' => '/ExternalData']);
        $this->pushBreadcrumb(['title' => $objectName, 'url' => '/ExternalData/'.$objectName]);
        $this->pushBreadcrumb(['title' => t('Common.edit'), 'url' => '/ExternalData/'.$objectName.'/edit/'.$id]);
    }
    public function edit_data(string $objectName, string $id)
    {
        $schema = (new ExternalData)->getObjectSchema($objectName);
        $data = (new ExternalData)->getObject($objectName, $id);
        return ['schema' => $schema, 'objectName'=>$objectName, 'data'=>$data, 'id'=>$id];
    }
}
