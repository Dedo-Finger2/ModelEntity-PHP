<?php

namespace app\entity;

abstract class Entity
{
    /**
     * Colunas da tabela no banco de dados
     *
     * @var array
     */
    protected array $attributes = [];


    /**
     * Método mágico que cria as colunas como atributos da classe dinâmicamente
     *
     * @param string $property - Nome da coluna na tabela do banco de dados
     * @param string $value - Valor da coluna na tabela do banco de dados
     */
    public function __set(string $property, mixed $value)
    {
        $this->attributes[$property] = $value;
    }


    /**
     * Método mágico que retorna as colunas que foram criadas dinamicamente individualmente
     *
     * @param string $property - Nome da coluna
     * @return string|null
     */
    public function __get(string $property)
    {
        return $this->attributes[$property] ?? null;
    }


    /**
     * Retorna todas as colunas da tabela
     *
     * @return array|null
     */
    public function getAttributes()
    {
        return $this->attributes ?? null;
    }
}
