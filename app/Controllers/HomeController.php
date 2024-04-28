<?php

namespace App\Controllers;

use App\Models\CheckoutModel;
use App\Models\ProductModel;
use App\Models\ProductTypeModel;
use App\Models\TaxModel;

class HomeController extends Controller
{
    /**
     * Método responsável por exibir a página inicial
     */
    public static function index()
    {
        $products = new ProductModel();
        $products->getAllRows();

        $productsType = new ProductTypeModel();
        $productsType->getAllRows();

        $taxes = new TaxModel();
        $taxes->getAllRows();

        $checkout = new CheckoutModel();
        $checkout->getAllRows();

        parent::render('index', [
            'products' => $products,
            'productsType' => $productsType,
            'taxes' => $taxes,
            'checkout' => $checkout
        ]);
    }
}
