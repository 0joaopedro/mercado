<?php

namespace App\Dao;

use PDO;
use App\Models\ProductModel;

class ProductDAO extends DAO
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
            'SELECT
                product.*,
                product_type.name as product_type_name
            FROM
                product
            LEFT JOIN
                product_type ON product.id_product_type = product_type.id
            ORDER BY
                id ASC'
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
            'SELECT * FROM product WHERE id = :id'
        );
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->execute();

        return $query->fetchObject('App\Models\ProductModel');
    }

    /**
     * Insere um registro no banco de dados
     * @param ProductModel $product
     */
    public function insert(ProductModel $product)
    {
        $query = $this->connection->prepare(
            'INSERT INTO product (id_product_type, name, value)
            VALUES (:id_product_type, :name, :value)'
        );

        $query->bindValue(':id_product_type', $product->id_product_type, PDO::PARAM_INT);
        $query->bindValue(':name', $product->name, PDO::PARAM_STR);
        $query->bindValue(':value', $product->value, PDO::PARAM_STR);

        $query->execute();
    }

    /**
     * Atualiza um valor específico no banco de dados
     * @param ProductModel $product
     */
    public function update(ProductModel $product)
    {
        $query = $this->connection->prepare(
            'UPDATE product SET
                id_product_type = :id_product_type,
                name = :name,
                value = :value
            WHERE id = :id'
        );

        $query->bindValue(':id_product_type', $product->id_product_type);
        $query->bindValue(':name', $product->name);
        $query->bindValue(':value', $product->value);
        $query->bindValue('id', $product->id);

        $query->execute();
    }
}
