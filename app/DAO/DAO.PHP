<?php

namespace App\DAO;

use PDO;
use PDOException;

abstract class DAO
{
    /**
     * Recebe a conexão do banco de dados e executa as operações
     * @var PDO
     */
    protected PDO $connection;

    /**
     * Método responsável por realizar a conexão com o banco de dados
     */
    public function __construct()
    {
        try {
            $dsn = "pgsql:host=" . $_ENV['db']['host'] . ";port=5432;dbname=" . $_ENV['db']['database'] . ";";

            $this->connection  = new PDO(
                $dsn,
                $_ENV['db']['username'],
                $_ENV['db']['password'],
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
