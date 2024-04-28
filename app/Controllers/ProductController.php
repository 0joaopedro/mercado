<?php

namespace App\Controllers;

use App\Helpers\Functions;
use App\Models\ProductModel;
use App\Models\ProductTypeModel;

class ProductController extends Controller
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
        $product = new ProductModel();
        $product->getAllRows();

        parent::render('product/list', $product);
    }

    /**
     * Método responsável por exibir a página de cadastro ou edição
     */
    public static function form()
    {
        $product = new ProductModel();

        $productsType = new ProductTypeModel();
        $productsType->getAllRows();

        if (isset($_GET['id'])) {
            $product = $product->getById((int) $_GET['id']);

            foreach ($productsType->rows as $key => $productType) {
                $productsType->rows[$key]->selected = $product->id_product_type === $productType->id ? true : false;
            }
        }

        parent::render('product/form', ['product' => $product, 'productsType' => $productsType]);
    }

    /**
     * Método responsável por salvar a criação ou edição
     */
    public static function save()
    {
        $product = new ProductModel();

        $product->id = $_POST['id'] ?? null;
        $product->name = $_POST['name'];
        $product->id_product_type = $_POST['id_product_type'];
        $product->value = str_replace(',', '.', str_replace('.', '', $_POST['value']));

        $product->save();

        header('Location: /');
    }
}
