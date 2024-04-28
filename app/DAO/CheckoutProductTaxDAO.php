<?php

namespace App\Dao;

use App\Helpers\Functions;
use PDO;
use App\Models\CheckoutProductTaxModel;

class CheckoutProductTaxDAO extends DAO
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
    public function selectById(int $id)
    {
        $query = $this->connection->prepare(
            'SELECT * FROM tax WHERE id = :id'
        );
        $query->bindValue(':id', $id);
        $query->execute();

        return $query->fetchObject('App\Models\CheckoutProductTaxModel');
    }

    public function selectByCheckoutProductId(int $idCheckoutProduct)
    {
        $query = $this->connection->prepare(
            'SELECT
                checkout_product_tax.*,
                tax.name
            FROM checkout_product_tax
            INNER JOIN tax ON checkout_product_tax.id_tax = tax.id
            WHERE id_checkout_product = :idCheckoutProduct'
        );
        $query->bindValue(':idCheckoutProduct', $idCheckoutProduct, PDO::PARAM_INT);
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
     * @param CheckoutProductTaxModel $product
     */
    public function insert(CheckoutProductTaxModel $product)
    {
        $query = $this->connection->prepare(
            'INSERT INTO checkout_product_tax (id_checkout_product, id_tax, value)
            VALUES (:id_checkout_product, :id_tax, :value)'
        );

        $query->bindValue(':id_checkout_product', $product->id_checkout_product, PDO::PARAM_INT);
        $query->bindValue(':id_tax', $product->id_tax, PDO::PARAM_INT);
        $query->bindValue(':value', $product->value, PDO::PARAM_STR);

        $query->execute();
    }
}
