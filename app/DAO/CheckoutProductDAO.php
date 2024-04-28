<?php

namespace App\Dao;

use PDO;
use App\Models\CheckoutProductModel;

class CheckoutProductDAO extends DAO
{
    /**
     * Recebe as propriedades da classe pai
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Seleciona um valor específico através do id
     * @param int $id
     * @return object
     */
    public function selectByCheckoutId(int $id_checkout)
    {
        $query = $this->connection->prepare(
            'SELECT
                product.*,
                checkout_product.quantity,
                checkout_product.id AS id_checkout_product,
                product_type.name AS product_type_name
            FROM checkout_product
            INNER JOIN product ON checkout_product.id_product = product.id
            INNER JOIN product_type ON product.id_product_type = product_type.id
            WHERE id_checkout = :id_checkout'
        );
        $query->bindValue(':id_checkout', $id_checkout);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_CLASS);
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
     * @param CheckoutProductModel $product
     */
    public function insert(CheckoutProductModel $product)
    {
        $query = $this->connection->prepare(
            'INSERT INTO checkout_product (id_checkout, id_product, quantity, value)
            VALUES (:id_checkout, :id_product, :quantity, :value)'
        );

        $query->bindValue(':id_checkout', $product->id_checkout, PDO::PARAM_INT);
        $query->bindValue(':id_product', $product->id_product, PDO::PARAM_INT);
        $query->bindValue(':quantity', $product->quantity, PDO::PARAM_INT);
        $query->bindValue(':value', $product->value, PDO::PARAM_STR);

        $query->execute();

        return $this->connection->lastInsertId();
    }
}
