<?php

namespace App\Core;

class Router {
    public function handleRequest() {
        $page = isset($_GET['page']) ? $_GET['page'] : 'home';
        $file = __DIR__ . '/../views/' . $page . '.php';

        if (file_exists($file)) {
            require_once __DIR__ . '/../views/header.php';
            require_once $file;
            require_once __DIR__ . '/../views/footer.php';
        } else {
            http_response_code(404);
            echo "<h1>Página não encontrada</h1>";
        }
    }
}