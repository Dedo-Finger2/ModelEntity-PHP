<?php

namespace app\model;
use app\database\Connection;
use app\database\relations\RelationshipBelongsTo;
use app\entity\Entity;
use app\lib\Helpers;

abstract class Model
{
    /**
     * Nome da tabela
     *
     * @var string
     */
    protected string $table;
    protected string $primaryKey;


    /**
     * Retorna todos os registros da tabela
     *
     * @param string $fields - Campos que serão retornados
     * @return array
     */
    public function all(string $fields = "*"): array
    {
        try {
            $connection = Connection::getConnection();
            $query = "select {$fields} from {$this->table}";
            $stmt = $connection->query($query);

            return $stmt->fetchAll(\PDO::FETCH_CLASS, $this->getEntity());
        } catch (\PDOException $e) {
            var_dump($e->getMessage());
            return [];
        }
    }


    /**
     * Método de criação de novos registros na tabela do banco de dados
     *
     * @param Entity $entity - Entidade, registro que será persistido no banco
     * @return bool - True se foi criado, False se não for criado
     */
    public function create(Entity $entity)
    {
        try {
            $connection = Connection::getConnection();
            $query = "insert into {$this->table}(";
            $query .= implode(",", array_keys($entity->getAttributes())).") values(";
            $query .= ':'.implode(",:", array_keys($entity->getAttributes())).")";
            
            $prepare = $connection->prepare($query);

            return $prepare->execute($entity->getAttributes());
        } catch (\PDOException $e) {
            var_dump($e->getMessage());
            return false;
        }
    }


    public function belongsTo(string $model, string $property = null)
    {
        return RelationshipBelongsTo::createWith(
            static::class,
            $model,
            $property,
        );
    }    


    public function relatedWith(array $ids)
    {
        $connection = Connection::getConnection();
        $query = "select * from {$this->table} where {$this->primaryKey} in (". implode(",", $ids) .")";
        $stmt = $connection->query($query);

        return $stmt->fetchAll(\PDO::FETCH_CLASS, $this->getEntity());
    }


    /**
     * Retorna a entidade do modelo
     *
     * @return string - Caminho da entidade
     */
    private function getEntity()
    { 
        // Pegando o nome da classe que executou o método
        $classShortName = Helpers::getClassShortName(static::class);
        
        // Pegando o caminho da entidade referente a esse modelo
        $entity = "app\\entity\\{$classShortName}Entity";
        
        // Verificando a entidade não existe
        if(!class_exists($entity)) {
            throw new \Exception("Entity {$entity} does not exist.");
        }

        return $entity;
    }
}
