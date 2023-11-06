<?php

namespace app\database\relations;
use app\lib\Helpers;
use app\model\Model;

class RelationshipBelongsTo
{
    public static function createWith(string $class, string $foreignClass, ?string $withProperty)
    {
        if (!class_exists($foreignClass)) {
            throw new \Exception("Class {$foreignClass} does not exists");
        }

        $modelClass = new $class;
        $results = $modelClass->all();

        $classShortName = Helpers::getClassShortName($foreignClass);
        $foreignKey = strtolower('id_'.$classShortName);

        $ids = array_map(function ($data) use($foreignKey) {
            return $data->$foreignKey;
        }, $results);

        $withName = self::getForeignProperty($classShortName, $withProperty);

        $relatedWith = new $foreignClass;
        $resultsFromRelated = $relatedWith->relatedWith(array_unique($ids));

        foreach ($results as $data) {
            foreach ($resultsFromRelated as $dataFromRelated) {
                if ($data->$foreignKey === $dataFromRelated->$foreignKey) {
                    $data->$withName = $dataFromRelated;
                }
            }
        }

        return $results;
    }

    
    private static function getForeignProperty(string $classShortName, ?string $withProperty)
    {
        return (!$withProperty) ? strtolower($classShortName) : $withProperty;
    }
}
