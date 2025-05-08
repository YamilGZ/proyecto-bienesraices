<?php

namespace MVC;

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

class Router {

    public $rutasGET = [];
    public $rutasPOST = [];

    public function get($url, $fn) {
        $this->rutasGET[$url] = $fn;
    }

    public function post($url, $fn) {
        $this->rutasPOST[$url] = $fn;
    }

    public function comprobarRutas() {

        session_start();
        $auth = $_SESSION['login'] ?? null;

        // arreglos de rutas protegidas
        $rutas_protegidas = ['/admin', '/propiedades/crear',
        '/vendedores/crear', '/propiedades/actualizar', 
        '/vendedores/actualizar', '/propiedades/eliminar',
        '/vendedores/eliminar'];


        $urlActual = $_SERVER['PATH_INFO'] ?? '/';
        $metodo = $_SERVER['REQUEST_METHOD'];

        if ($metodo === 'GET') {
            $fn = $this->rutasGET[$urlActual] ?? null;
        } else {
            $fn = $this->rutasPOST[$urlActual] ?? null;
        }

        // proteger las rutas
        if (in_array($urlActual, $rutas_protegidas) && !$auth) {
            header('Location: /');
        }

        if ($fn) {
            // la URL existe y hay una funcion asociada
            call_user_func($fn, $this);
        }else {
            echo "pagina no encontrada";
        }
    }

    // muestra una vista
    public function render($view, $datos = []) {

        foreach($datos as $key => $value) {
            $$key = $value;
        }       

        ob_start();// almacenamos en memoria durante un momento...

        include __DIR__ . "/views/$view.php";

        $contenido = ob_get_clean();// limpia el buffer

        include __DIR__ . "/views/layout.php";
    }

}