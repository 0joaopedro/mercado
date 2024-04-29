<?php

namespace App\Models;

use App\DAO\ProductTypeDAO;

class ProductTypeModel extends Model
{
    /**
     * Recebe a conexão com o banco de dados
     * @var ProductTypeDAO
     */
    private $dao;

    /**
     * ID do tipo de produto
     * @var int
     */
    public $id;

    /**
     * Nome do tipo de produto
     * @var string
     */
    public $name;

    /**
     * Status do tipo do produto
     * @var int
     */
    public $status;

    /**
     * Declara o objeto model para ser utilizado ao longo da classe
     */
    public function __construct()
    {
        $this->dao = new ProductTypeDAO();
    }

    /**
     * Método responsável por salvar alteração ou inserir no banco de dados
     */
    public function save()
    {
        return $this->id ? $this->dao->update($this) : $this->dao->insert($this);
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
    public function getAllRows()
    {
        $this->rows = $this->dao->select();
    }

    /**
     * Método responsável por deletar um tipo de produto específico
     * @param int $id
     */
    public function delete(int $id)
    {
        $this->dao->delete($id);
    }
}
