<?php

namespace app\database;

use PDO;

abstract class Connection
{
    /**
     * Objeto contendo a conexão com o banco de dados
     *
     * @var PDO|null
     */
    private static ?PDO $connection = null;


    /**
     * Método reponsável por retornar a conexão com o banco de dados
     *
     * @return PDO|null
     */
    public static function getConnection(): ?PDO
    {
        // Se não houver conexão, criar uma nova
        if (!self::$connection) {
            self::$connection = new PDO("mysql:host=localhost;dbname=rede_social", "root", "", 
            [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_CLASS,
            ]);
        }

        return self::$connection;
    }
}
