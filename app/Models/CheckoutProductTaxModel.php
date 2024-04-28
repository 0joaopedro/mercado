<?php

namespace App\Models;

use App\DAO\CheckoutProductTaxDAO;

class CheckoutProductTaxModel extends Model
{
    /**
     * Recebe a conexão com o banco de dados
     * @var CheckoutProductTaxDAO
     */
    private $dao;

    /**
     * ID da taxa do produto comprado
     * @var int
     */
    public $id;

    /**
     * Chave estrangeira do produto comprado
     * @var int
     */
    public $id_checkout_product;

    /**
     * Chave estrangeira das taxas
     * @var int
     */
    public $id_tax;

    /**
     * Valor do imposto aplicado no valor total do produto
     * @var string
     */
    public $value;

    /**
     * Declara o objeto model para ser utilizado ao longo da classe
     */
    public function __construct()
    {
        $this->dao = new CheckoutProductTaxDAO();
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

    public function getByCheckoutProductId(int $id)
    {
        return $this->dao->selectByCheckoutProductId($id);
    }

    public function getByTypeProductId(int $id)
    {
        $this->rows = $this->dao->selectByProductTypeId($id);
    }
}
