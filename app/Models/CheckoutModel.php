<?php

namespace App\Models;

use App\DAO\CheckoutDAO;
use App\Helpers\Functions;

class CheckoutModel extends Model
{
    /**
     * Recebe a conexão com o banco de dados
     * @var CheckoutDAO
     */
    private $dao;

    /**
     * ID do Checkout
     * @var int
     */
    public $id;

    /**
     * Valor total da compra
     * @var string
     */
    public $value;

    /**
     * Valor total de imposto
     * @var string
     */
    public $value_tax;

    /**
     * Declara o objeto model para ser utilizado ao longo da classe
     */
    public function __construct()
    {
        $this->dao = new CheckoutDAO();
    }

    /**
     * Método responsável por salvar alteração ou inserir no banco de dados
     */
    public function save()
    {
        return $this->dao->insert($this);
    }

    /**
     * Método responsável por retornar um valor específico
     * @param int $id
     * @return object
     */
    public function getById(int $id)
    {
        $checkout = $this->dao->selectById($id);

        return $checkout ?: null;
    }

    /**
     * Método responsável por retornar todos os valores
     * @param int $id
     */
    public function getAllRows(int $id = null)
    {
        $this->rows = $this->dao->select($id);
    }

    public function getByTypeProductId(int $id)
    {
        $this->rows = $this->dao->selectByProductTypeId($id);
    }
}
