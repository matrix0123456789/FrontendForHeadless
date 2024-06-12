<?php

namespace ExternalData\BussinesLogic;

interface DataSourceInterface
{
    public function getSchemaNames(): array;
    public function getSchema(string $objectName): object;
    public function getTable(string $objectName, object $config): object;
    public function insert(string $objectName, $object);
    public function update(string $objectName,string $id, $object);
    public function getObject(string $objectName, string $id);
}
