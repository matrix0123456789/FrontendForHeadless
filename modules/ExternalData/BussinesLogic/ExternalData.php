<?php

namespace ExternalData\BussinesLogic;

use Common\ExternalDataInitialization;
use MKrawczyk\FunQuery\FunQuery;

class ExternalData
{
    /**
     * @var DataSourceInterface[]
     */
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
        $rows = FunQuery::create($data->rows);
        $rows = $rows->map(function ($x) {
            $x->id = $x->id ?? $x->_id;
            return $x;
        });
        if(!$data->filtered && !empty($config->columnFilters)){
            $rows = $rows->filter(fn($x) => $this->passesColumnFilters($x, $config->columnFilters));
        }
        if (!$data->sorted && $config->sort) {
            $rows = $rows->sort(fn($a) => $a->{$config->sort->col});
            dump($config->sort);
            if ($config->sort->desc)
                $rows = $rows->reverse();
        }
        if (!$data->pagination) {
            $rows = FunQuery::create($rows)->skip($config->start)->limit($config->limit);
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

    public function update(string $objectName, string $id, $object)
    {
        $dataSource = $this->getDataSource($objectName);
        $dataSource->update($objectName, $id, $object);
    }

    public function getObject(string $objectName, string $id)
    {
        $dataSource = $this->getDataSource($objectName);
        return $dataSource->getObject($objectName, $id);
    }

    public function getObjectTypes()
    {
        return FunQuery::from(self::$dataSources)->map(fn($x) => $x->getSchemaNames())->flat()->toArray();
    }

    private function passesColumnFilters($x, $columnFilters)
    {
        foreach ($columnFilters as $column =>$filter){
            if($filter->type=='equals'){
                if($x->{$column} != $filter->value)
                    return false;
            }else if($filter->type=='contains') {
                if (strpos($x->{$column}, $filter->value) === false)
                    return false;
            }else if($filter->type=='more'){
                if($x->{$column} <= $filter->value)
                    return false;
            }else if($filter->type=='less'){
                if($x->{$column} >= $filter->value)
                    return false;
            }
            else if($filter->type=='oneOf'){
                if(!in_array($x->{$column}, explode(',',$filter->value)))
                    return false;
            }else if ($filter->type=='empty'){
                if($x->{$column} != '')
                    return false;
            }

        }
        return true;
    }
}

ExternalDataInitialization::init();
