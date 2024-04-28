<?php

namespace App\Dao;

use PDO;
use App\Models\TaxProductTypeModel;

class TaxProductTypeDAO extends DAO
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
            'SELECT * FROM product WHERE id = :id'
        );
        $query->bindValue(':id', $id);
        $query->execute();

        return $query->fetchObject('App\Models\TaxProductTypeModel');
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
                *
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
     * @param TaxProductTypeModel $product
     */
    public function insert(TaxProductTypeModel $TaxProductTypeModel)
    {
        $query = $this->connection->prepare(
            'INSERT INTO tax_product_type (id_tax, id_product_type)
            VALUES (:id_tax, :id_product_type)'
        );

        $query->bindValue(':id_tax', $TaxProductTypeModel->id_tax, PDO::PARAM_INT);
        $query->bindValue(':id_product_type', $TaxProductTypeModel->id_product_type, PDO::PARAM_INT);

        $query->execute();
    }

    /**
     * Deleta um valor específico do banco de dados
     * @param int $id
     */
    public function deleteByProductTypeId(int $id)
    {
        $query = $this->connection->prepare(
            'DELETE FROM tax_product_type WHERE id_product_type = :id'
        );
        $query->bindValue(':id', $id);

        $query->execute();
    }
}
