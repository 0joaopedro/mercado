<?php

namespace App\Models;

use App\DAO\CheckoutProductDAO;

class CheckoutProductModel extends Model
{
    /**
     * Recebe a conexão com o banco de dados
     * @var CheckoutProductDAO
     */
    private $dao;

    /**
     * ID do Checkout Product
     * @var int
     */
    public $id;

    /**
     * ID da chave estrangeira Checkout
     * @var int
     */
    public $id_checkout;

    /**
     * ID da chave estrangeira Product
     * @var int
     */
    public $id_product;

    /**
     * Quantidade de produto comprado
     * @var int
     */
    public $quantity;

    /**
     * Valor unitário do produto na hora da compra
     * @var string
     */
    public $value;

    /**
     * Objeto que herda as taxas de CheckoutProductsTaxes
     * @object CheckoutProductTaxModel
     */
    public $checkoutProductsTaxes;

    /**
     * Declara o objeto model para ser utilizado ao longo da classe
     */
    public function __construct()
    {
        $this->dao = new CheckoutProductDAO();
    }

    /**
     * Método responsável por salvar alteração ou inserir no banco de dados
     */
    public function save()
    {
        return $this->dao->insert($this);
    }

    public function getByCheckoutId(int $id)
    {
        $this->rows = $this->dao->selectByCheckoutId($id);
    }

    public function getByTypeProductId(int $id)
    {
        $this->rows = $this->dao->selectByProductTypeId($id);
    }
}
