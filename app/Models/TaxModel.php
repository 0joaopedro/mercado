<?php

namespace App\Models;

use App\DAO\TaxDAO;

class TaxModel extends Model
{
    /**
     * Recebe a conexão com o banco de dados
     * @var TaxDAO
     */
    private $dao;

    /**
     * ID do imposto
     * @var int
     */
    public $id;

    /**
     * Porcentagem do imposto
     * @var int
     */
    public $value;

    /**
     * Nome do imposto
     * @var string
     */
    public $name;

    /**
     * Status do imposto
     * @var int
     */
    public $status;

    /**
     * Declara o objeto model para ser utilizado ao longo da classe
     */
    public function __construct()
    {
        $this->dao = new TaxDAO();
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
    public function getAllRows(int $id = null)
    {
        $this->rows = $this->dao->select($id);
    }

    public function getByTypeProductId(int $id)
    {
        $this->rows = $this->dao->selectByProductTypeId($id);
    }

    /**
     * Método responsável por deletar um imposto específico
     * @param int $id
     */
    public function delete(int $id)
    {
        $this->dao->delete($id);
    }
}
