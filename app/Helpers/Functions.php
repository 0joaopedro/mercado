<?php

namespace App\Helpers;

class Functions
{
    /**
     * Função de debug que auxiliou no desenvolvimento
     * @param mixed $data
     */
    public static function dd($data)
    {
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
        die;
    }
}
