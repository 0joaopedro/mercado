<?php

namespace App\Dao;

use PDO;
use App\Models\CheckoutModel;

class CheckoutDAO extends DAO
{
    /**
     * Recebe as propriedades da classe pai
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Seleciona todos os registros
     * @return object
     */
    public function select()
    {
        $query = $this->connection->prepare(
            'SELECT * FROM checkout
            ORDER BY id ASC'
        );
        $query->execute();

        return $query->fetchAll(PDO::FETCH_CLASS);
    }

    /**
     * Seleciona um valor específica através do id
     * @param int $id
     * @return object
     */
    public function selectById(int $id)
    {
        $query = $this->connection->prepare(
            'SELECT * FROM checkout WHERE id = :id
            ORDER BY id ASC'
        );
        $query->bindValue(':id', $id);
        $query->execute();

        return $query->fetchObject('App\Models\CheckoutModel');
    }

    /**
     * Seleciona um valor específico através do id
     * @param int $id
     * @return object
     */
    public function selectByProductTypeId(int $id)
    {
        $query = $this->connection->prepare(
            'SELECT
                tax.*
            FROM tax_product_type
            INNER JOIN tax ON tax.id = tax_product_type.id_tax
            WHERE id_product_type = :id'
        );
        $query->bindValue(':id', $id);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_CLASS);
    }

    /**
     * Insere um registro no banco de dados
     * @param CheckoutModel $product
     */
    public function insert(CheckoutModel $product)
    {
        $query = $this->connection->prepare(
            'INSERT INTO checkout (value, value_tax)
            VALUES (:value, :value_tax)'
        );

        $query->bindValue(':value', $product->value, PDO::PARAM_STR);
        $query->bindValue(':value_tax', $product->value_tax, PDO::PARAM_STR);

        $query->execute();

        return $this->connection->lastInsertId();
    }
}
