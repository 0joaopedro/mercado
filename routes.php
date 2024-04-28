<?php

use App\Controllers\CheckoutController;
use App\Controllers\HomeController;
use App\Controllers\ProductController;
use App\Controllers\ProductTypeController;
use App\Controllers\TaxController;

$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch ($url) {
    case '/':
        HomeController::index();
        break;
    case '/product/form':
        ProductController::form();
        break;
    case '/product/save':
        ProductController::save();
        break;
    case '/product-type/form':
        ProductTypeController::form();
        break;
    case '/product-type/save':
        ProductTypeController::save();
        break;
    case '/tax/form':
        TaxController::form();
        break;
    case '/tax/save':
        TaxController::save();
        break;
    case '/checkout/form':
        CheckoutController::form();
        break;
    case '/checkout/view':
        CheckoutController::view();
        break;
    case '/checkout/save':
        CheckoutController::save();
        break;
}
