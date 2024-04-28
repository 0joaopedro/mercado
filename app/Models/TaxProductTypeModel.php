<?php

namespace App\Models;

use App\DAO\TaxProductTypeDAO;

class TaxProductTypeModel extends Model
{
    /**
     * Recebe a conexão com o banco de dados
     * @var TaxProductTypeDAO
     */
    private $dao;

    /**
     * ID do imposto
     * @var int
     */
    public $id_tax;

    /**
     * ID do tipo de produto
     * @var int
     */
    public $id_product_type;

    /**
     * Declara o objeto model para ser utilizado ao longo da classe
     */
    public function __construct()
    {
        $this->dao = new TaxProductTypeDAO();
    }

    /**
     * Método responsável por salvar alteração ou inserir no banco de dados
     */
    public function save()
    {
        $this->dao->insert($this);
    }

    /**
     * Método responsável por retornar um valor específico
     * @param int $id
     * @return object
     */
    public function getById(int $id)
    {
        $product = $this->dao->selectById($id);

        return $product ?: null;
    }

    /**
     * Método responsável por retornar todos os valores
     * @param int $id
     */
    public function getAllByProductTypeId(int $id)
    {
        $this->rows = $this->dao->selectByProductTypeId($id);
    }

    /**
     * Método responsável por deletar um valor específico
     * @param int $id
     */
    public function deleteByProductTypeId(int $id)
    {
        $this->dao->deleteByProductTypeId($id);
    }
}
