<?php

namespace ExternalData\BussinesLogic;

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

    public function getTable(string $objectName): object
    {
        $schema = $this->getSchema($objectName);
        $data = json_decode(file_get_contents($schema->endpoint), false);
        return (object)['rows' => $data->data, 'total' => count($data->data)];
    }
}
