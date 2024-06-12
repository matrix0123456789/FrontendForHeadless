<?php

namespace ExternalData\BussinesLogic;

interface DataSourceInterface
{
    public function getSchemaNames(): array;
    public function getSchema(string $objectName): object;
    public function getTable(string $objectName): object;
}
