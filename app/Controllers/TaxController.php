<?php

namespace App\Controllers;

use App\Models\TaxModel;

class TaxController extends Controller
{
    /**
     * Método responsável por retornar json para requisições
     * @param mixed $arr
     * @param int $code
     */
    protected function returnJson($arr, $code = 200)
    {
        http_response_code($code);
        header('Content-Type: application/json');
        echo json_encode($arr);
        die();
    }

    /**
     * Método responsável por exibir a página inicial de listagem
     */
    public static function index()
    {
        $tax = new TaxModel();
        $tax->getAllRows();

        parent::render('tax/list', $tax);
    }

    /**
     * Método responsável por exibir a página de cadastro ou edição
     */
    public static function form()
    {
        $tax = new TaxModel();

        if (isset($_GET['id'])) {
            $tax = $tax->getById((int) $_GET['id']);
        }

        parent::render('tax/form', $tax);
    }

    /**
     * Método responsável por salvar a criação ou edição
     */
    public static function save()
    {
        $tax = new TaxModel();

        $tax->id = $_POST['id'] ?? null;
        $tax->name = $_POST['name'];
        $tax->value = $_POST['value'];

        $tax->save();

        header('Location: /');
    }
}
