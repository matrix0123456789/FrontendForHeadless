<?php

namespace ExternalData\BussinesLogic;

use Common\ExternalDataInitialization;
use MKrawczyk\FunQuery\FunQuery;

class ExternalData
{
    private static array $dataSources = [];

    public static function registerDataSource(DataSourceInterface $dataSource)
    {
        self::$dataSources[] = $dataSource;
    }

    public function getDataSource(string $objectName)
    {
        foreach (self::$dataSources as $dataSource) {
            $has = FunQuery::create($dataSource->getSchemaNames())->some(fn($x) => $x == $objectName);
            if ($has) {
                return $dataSource;
            }
        }

        return null;
    }

    public function getObjectSchema(string $objectName)
    {
        return $this->getDataSource($objectName)->getSchema($objectName);
    }

    public function getTable($config)
    {
        $objectName = $config->params->objectName;
        dump($objectName);
        $dataSource = $this->getDataSource($objectName);
        $data = $dataSource->getTable($objectName, $config);
        $rows = $data->rows;
        if (!$data->pagination) {
            $rows = array_slice($rows, $config->start, $config->limit);
            $total = count($data->rows);
        } else {
            $total = $data->total;
        }
        return ['rows' => $rows, 'total' => $total];
    }

    public function insert(string $objectName, $object)
    {
        $dataSource = $this->getDataSource($objectName);
        $dataSource->insert($objectName, $object);
    }
}

ExternalDataInitialization::init();
