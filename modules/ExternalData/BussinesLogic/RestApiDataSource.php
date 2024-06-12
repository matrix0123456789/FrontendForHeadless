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
        $ret=[];
        $ret['rows']=$data->data;
        if(isset($data->total)){
            $ret['total']=$data->total;
        }
        $ret['pagination']=isset($data->pagination) && $data->pagination==true;
        return (object)$ret;
    }
}
