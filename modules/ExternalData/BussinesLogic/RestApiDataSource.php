<?php

namespace ExternalData\BussinesLogic;

use MKrawczyk\FunQuery\FunQuery;

class RestApiDataSource implements DataSourceInterface
{
    private $schema = null;
    private string $schemaURL;

    public function __construct(string $schemaURL)
    {
        $this->schemaURL = $schemaURL;
    }

    private function init()
    {
        if ($this->schema == null) {
            $this->schema = json_decode(file_get_contents($this->schemaURL), false);
        }
    }

    public function getSchemaNames(): array
    {
        $this->init();

        return array_keys((array)$this->schema);
    }

    public function getSchema(string $objectName): object
    {
        $this->init();
        return $this->schema->$objectName;
    }

    public function getTable(string $objectName, object $config): object
    {
        $schema = $this->getSchema($objectName);
        $urlParams = [];
        foreach ($config as $key => $value) {
            if (is_string($value) || is_numeric($value))
                $urlParams[] = $key.'='.urlencode((string)$value);
        }
        $data = json_decode(file_get_contents($schema->endpoint.'?'.implode('&', $urlParams)), false);
        $ret = [];
        $ret['rows'] = $data->data;
        if (isset($data->total)) {
            $ret['total'] = $data->total;
        }
        $ret['pagination'] = isset($data->pagination) && $data->pagination == true;
        return (object)$ret;
    }

    public function insert(string $objectName, $object)
    {
        $url = $this->getSchema($objectName)->endpoint;

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($object));
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_exec($curl);
    }

    public function getObject(string $objectName, string $id)
    {
        $schema = $this->getSchema($objectName);
        $data = json_decode(file_get_contents($schema->endpoint.'/'.$id), false);
        return $data->data;
    }

    public function update(string $objectName, string $id, $object)
    {
        $url = $this->getSchema($objectName)->endpoint;
        $url .= '/'.$id;
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($object));
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_exec($curl);
    }
}
