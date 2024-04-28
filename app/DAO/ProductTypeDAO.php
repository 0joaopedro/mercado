<?php

namespace App\Dao;

use PDO;
use App\Models\ProductTypeModel;

class ProductTypeDAO extends DAO
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
            'SELECT * FROM product_type
            ORDER BY id ASC'
        );
        $query->execute();

        return $query->fetchAll(PDO::FETCH_CLASS);
    }

    /**
     * Seleciona um valor específico através do id
     * @param int $id
     * @return object
     */
    public function selectById(int $id)
    {
        $query = $this->connection->prepare(
            'SELECT * FROM product_type WHERE id = :id'
        );
        $query->bindValue(':id', $id);
        $query->execute();

        return $query->fetchObject('App\Models\ProductTypeModel');
    }

    /**
     * Insere um registro no banco de dados
     * @param ProductTypeModel $product
     */
    public function insert(ProductTypeModel $product)
    {
        $query = $this->connection->prepare(
            'INSERT INTO product_type (name)
            VALUES (:name)'
        );

        $query->bindValue(':name', $product->name, PDO::PARAM_STR);

        $query->execute();

        return $this->connection->lastInsertId();
    }

    /**
     * Atualiza um valor específico no banco de dados
     * @param ProductTypeModel $product
     */
    public function update(ProductTypeModel $productType)
    {
        $query = $this->connection->prepare(
            'UPDATE product_type SET
                name = :name
            WHERE id = :id'
        );

        $query->bindValue(':name', $productType->name);
        $query->bindValue('id', $productType->id);

        $query->execute();

        return $productType->id;
    }
}
