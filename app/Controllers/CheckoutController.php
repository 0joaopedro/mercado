<?php

namespace App\Controllers;

use App\Models\CheckoutModel;
use App\Models\CheckoutProductModel;
use App\Models\ProductModel;
use App\Models\TaxModel;
use App\Models\CheckoutProductTaxModel;

class CheckoutController extends Controller
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
     * Método responsável por exibir a página de cadastro de venda
     */
    public static function form()
    {
        $products = new ProductModel();
        $products->getAllRows();

        foreach ($products->rows as $key => $product) {
            $products->rows[$key]->taxProductType = new TaxModel();
            $products->rows[$key]->taxProductType->getByTypeProductId($product->id_product_type);
        }

        parent::render('checkout/form', ['products' => $products]);
    }

    /**
     * Método responsável pela visualização da compra
     */
    public static function view()
    {
        if (!isset($_GET['id'])) {
            return;
        }

        $id = $_GET['id'];

        $checkout = new CheckoutModel();
        $checkout = $checkout->getById($id);

        $checkoutProducts = new CheckoutProductModel();
        $checkoutProducts->getByCheckoutId($checkout->id);

        foreach ($checkoutProducts->rows as $key => $checkoutProduct) {
            $checkoutProductsTaxes = new CheckoutProductTaxModel();
            $checkoutProductsTaxes = $checkoutProductsTaxes->getByCheckoutProductId($checkoutProduct->id_checkout_product);

            $checkoutProducts->rows[$key]->checkoutProductsTaxes = $checkoutProductsTaxes;
        }

        // Functions::dd($checkout);

        parent::render('checkout/view', [
            'checkout' => $checkout,
            'checkoutProducts' => $checkoutProducts
        ]);
    }

    /**
     * Método responsável por salvar a criação
     */
    public static function save()
    {
        bcscale(2);

        $productsData = [];
        $checkoutTotal = 0;
        $checkoutTotalTaxes = 0;

        parse_str($_POST['data'], $productsData);

        foreach ($productsData['product'] as $idProduct => $quantity) {
            $product = new ProductModel();
            $product = $product->getById((int) $idProduct);

            $checkoutProducts[$idProduct] = new CheckoutProductModel();
            $checkoutProducts[$idProduct]->id_product = $idProduct;
            $checkoutProducts[$idProduct]->quantity = $quantity;
            $checkoutProducts[$idProduct]->value = $product->value;

            $taxes = new TaxModel();
            $taxes->getByTypeProductId($product->id_product_type);

            $productTotal = bcmul($product->value, $quantity);

            $checkoutTotal = bcadd($checkoutTotal, $productTotal);

            foreach ($taxes->rows as $tax) {
                $checkoutProductsTaxes = new CheckoutProductTaxModel();

                $percentage = bcdiv($tax->value, '100', 4);

                $taxTotal = bcmul($productTotal, $percentage);

                $checkoutProductsTaxes->id_tax = $tax->id;
                $checkoutProductsTaxes->value = $taxTotal;

                $checkoutTotal = bcadd($checkoutTotal, $checkoutProductsTaxes->value);
                $checkoutTotalTaxes = bcadd($checkoutTotalTaxes, $checkoutProductsTaxes->value);

                $checkoutProducts[$idProduct]->checkoutProductsTaxes[] = $checkoutProductsTaxes;
            }
        }

        $checkout = new CheckoutModel();
        $checkout->value = $checkoutTotal;
        $checkout->value_tax = $checkoutTotalTaxes;

        $checkoutId = $checkout->save();

        foreach ($checkoutProducts as $checkoutProduct) {
            $checkoutProduct->id_checkout = $checkoutId;

            $checkoutProductId = $checkoutProduct->save();

            if ($checkoutProduct->checkoutProductsTaxes) {
                foreach ($checkoutProduct->checkoutProductsTaxes as $checkoutProductTaxes) {
                    $checkoutProductTaxes->id_checkout_product = $checkoutProductId;

                    $checkoutProductTaxes->save();
                }
            }
        }

        $controller = new CheckoutController();
        $controller->returnJson(['/checkout/view?id=' . $checkoutId]);
    }
}
