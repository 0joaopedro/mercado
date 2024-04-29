<?php

namespace App\Dao;

use PDO;
use App\Models\TaxModel;

class TaxDAO extends DAO
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
            'SELECT * FROM tax
            WHERE status = 1
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
            'SELECT * FROM tax WHERE id = :id'
        );
        $query->bindValue(':id', $id);
        $query->execute();

        return $query->fetchObject('App\Models\TaxModel');
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
            WHERE id_product_type = :id
                AND tax.status = 1'
        );
        $query->bindValue(':id', $id);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_CLASS);
    }

    /**
     * Insere um registro no banco de dados
     * @param TaxModel $product
     */
    public function insert(TaxModel $product)
    {
        $query = $this->connection->prepare(
            'INSERT INTO tax (name, value)
            VALUES (:name, :value)'
        );

        $query->bindValue(':name', $product->name, PDO::PARAM_STR);
        $query->bindValue(':value', $product->value, PDO::PARAM_STR);

        $query->execute();
    }

    /**
     * Atualiza um valor específico no banco de dados
     * @param TaxModel $product
     */
    public function update(TaxModel $product)
    {
        $query = $this->connection->prepare(
            'UPDATE tax SET
                name = :name,
                value = :value
            WHERE id = :id'
        );

        $query->bindValue(':name', $product->name);
        $query->bindValue(':value', $product->value);
        $query->bindValue('id', $product->id);

        $query->execute();
    }

    /**
     * Deleta um imposto específico do banco de dados
     * @param int $id
     */
    public function delete(int $id)
    {
        $query = $this->connection->prepare(
            'UPDATE tax SET
                status = 0
            WHERE id = :id'
        );
        $query->bindValue(':id', $id);

        $query->execute();
    }
}
