<?php

namespace App\Controllers;

abstract class Controller
{
    /**
     * Método responsável por incluir e exibir a view
     * @param string $view
     * @param object $data
     */
    protected static function render($view, $data = null)
    {
        $viewFile = VIEWS . $view . ".php";

        if (file_exists($viewFile)) {
            include VIEWS . "header.php";
            include $viewFile;
            include VIEWS . "footer.php";
        } else {
            exit('Arquivo não encontrado: ' . $view);
        }
    }
}
