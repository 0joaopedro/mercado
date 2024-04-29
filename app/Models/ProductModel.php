<?php

namespace App\Models;

use App\DAO\ProductDAO;

class ProductModel extends Model
{
    /**
     * Recebe a conexão com o banco de dados
     * @var ProductDAO
     */
    private $dao;

    /**
     * ID do produto
     * @var int
     */
    public $id;

    /**
     * ID do tipo de produto
     * @var int
     */
    public $id_product_type;

    /**
     * Nome do produto
     * @var string
     */
    public $name;

    /**
     * Valor do produto
     * @var string
     */
    public $value;

    /**
     * Status do produto
     * @var int
     */
    public $status;

    /**
     * Declara o objeto model para ser utilizado ao longo da classe
     */
    public function __construct()
    {
        $this->dao = new ProductDAO();
    }

    /**
     * Método responsável por salvar alteração ou inserir no banco de dados
     */
    public function save()
    {
        $this->id ? $this->dao->update($this) : $this->dao->insert($this);
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
     * Método responsável por deletar um produto específico
     * @param int $id
     */
    public function delete(int $id)
    {
        $this->dao->delete($id);
    }
}
