<?php

/**
 * Função responsável por realizar o autoload de arquivos
 */
spl_autoload_register(function ($className) {
    $fileName = str_replace('\\', '/', $className) . '.php';

    $filePath = __DIR__ . '/' . $fileName;

    if (file_exists($filePath)) {
        require_once $filePath;
    }
});
