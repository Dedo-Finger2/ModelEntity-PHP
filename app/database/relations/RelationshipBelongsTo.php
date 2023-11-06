<?php

namespace app\database\relations;
use app\lib\Helpers;

class RelationshipBelongsTo
{
    /**
     * Método que cria a relação entre os modelos
     *
     * @param string $class - Classe principal
     * @param string $foreignClass - Outra classe
     * @param string|null $withProperty - Nome da propriedade que vai guardar a relação entre modelos
     */
    public static function createWith(string $class, string $foreignClass, ?string $withProperty)
    {
        if (!class_exists($foreignClass)) {
            throw new \Exception("Class {$foreignClass} does not exists");
        }

        $classObj = new $class;
        $results = $classObj->all();

        $classShortName = Helpers::getClassShortName($foreignClass);
        $id = strtolower('id_'.$classShortName);    // Isso segue o padrão de criação de ID do seu banco, nesse caso é "id_nomeTabela"

        // Pegando todos os IDs
        $ids = array_map(function ($data) use($id) {
            return $data->$id;
        }, $results);

        $foreignProperty = self::getForeignProperty($classShortName, $withProperty);

        $foreignObj = new $foreignClass;
        $resultsFromRelated = $foreignObj->relatedWith(array_unique($ids));

        foreach ($results as $firstTableResult) {
            foreach ($resultsFromRelated as $foreignTableResult) {
                if ($firstTableResult->$id === $foreignTableResult->$id) {
                    $firstTableResult->$foreignProperty = $foreignTableResult;
                }
            }
        }

        return $results;
    }

    
    /**
     * Retorna a propriedade que estabelece realção entre os modelos
     *
     * @param string $classShortName - Nome da classe
     * @param string|null $withProperty - Nome da nova coluna que vai receber o objeto relacionado
     * @return string
     */
    private static function getForeignProperty(string $classShortName, ?string $withProperty)
    {
        return (!$withProperty) ? strtolower($classShortName) : $withProperty;
    }
}
