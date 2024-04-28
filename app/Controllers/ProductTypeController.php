<?php

namespace App\Controllers;

use App\Models\ProductTypeModel;
use App\Models\TaxModel;
use App\Models\TaxProductTypeModel;

class ProductTypeController extends Controller
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
        $productType = new ProductTypeModel();
        $productType->getAllRows();

        parent::render('product-type/list', $productType);
    }

    /**
     * Método responsável por exibir a página de cadastro ou edição
     */
    public static function form()
    {
        $productType = new ProductTypeModel();

        $taxes = new TaxModel();
        $taxes->getAllRows();

        if (isset($_GET['id'])) {
            $productType = $productType->getById((int) $_GET['id']);

            $taxesChecked = new TaxProductTypeModel();
            $taxesChecked->getAllByProductTypeId((int) $productType->id);

            if ($taxesChecked) {
                foreach ($taxesChecked->rows as $taxechecked) {
                    $checked = array_search($taxechecked->id_tax, array_column($taxes->rows, 'id'));

                    $taxes->rows[$checked]->checked = true;
                }
            }
        }

        parent::render('product-type/form', [
            'productType' => $productType,
            'taxes' => $taxes
        ]);
    }

    /**
     * Método responsável por salvar a criação ou edição
     */
    public static function save()
    {
        $productType = new ProductTypeModel();

        $productType->id = $_POST['id'] ?? null;
        $productType->name = $_POST['name'];

        $productType->id = $productType->save();

        $taxesProductType = new TaxProductTypeModel();
        $taxesProductType->deleteByProductTypeId($productType->id);

        if (isset($_POST['taxes'])) {
            foreach ($_POST['taxes'] as $tax) {
                $taxesProductType->id_product_type = $productType->id;
                $taxesProductType->id_tax = array_key_first($tax);
                $taxesProductType->save();
            }
        }

        header('Location: /');
    }
}
