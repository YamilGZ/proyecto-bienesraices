<?php 

namespace Controllers;
use MVC\Router;
use Model\Propiedad;
use Model\Vendedor;
use Intervention\Image\ImageManagerStatic as Image;

class PropiedadController {

    public static function index(Router $router) {

        $propiedades = Propiedad::all();
        $vendedores = Vendedor::all();

        // Muestra mensaje condicional
        $resultado = $_GET['resultado'] ?? null;

        $router->render('propiedades/admin', [
            'propiedades' => $propiedades,
            'resultado' => $resultado,
            'vendedores' => $vendedores
        ]);
    }

    public static function crear(Router $router) {

        $propiedad = new Propiedad;
        $vendedores = Vendedor::all();
        // Arreglo con mensajes de errores
        $errores = Propiedad::getErrores();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            /* Crea una nueva instancia */
            $propiedad = new Propiedad($_POST['propiedad']);

            /*SUBIDA DE ARCHIVOS*/
            
            // Generar un nombre unico
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

            // setear la imagen
            if ($_FILES['propiedad']['tmp_name']['imagen']) {
                // Realiza un resize a la imagen con intervention
                $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
                $propiedad->setImagen($nombreImagen);
            }
            
            // Validar
            $errores = $propiedad->Validar();

            // Revisar que el array de errores este vacio
            if (empty($errores)) {

                // Crear la carpeta para subir imagenes
                if (!is_dir(CARPETA_IMAGENES)) {
                    mkdir(CARPETA_IMAGENES);
                }

                // guardar la imagen en el servidor
                $image->save(CARPETA_IMAGENES . $nombreImagen);

                // guardar en la base de datos
                $resultado = $propiedad->Guardar();

            }
        }


        $router->render('propiedades/crear', [
            'propiedad' => $propiedad,
            'vendedores' => $vendedores,
            'errores' => $errores
        ]);
    }

    public static function actualizar(Router $router) {
        $id = validarORedireccionar('/admin');

        $propiedad = Propiedad::find($id);
        $vendedores = Vendedor::all();
        // Arreglo con mensajes de errores
        $errores = Propiedad::getErrores();

        // metodo post para actualizar
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Asignar los atributos
            $args = $_POST['propiedad'];

            $propiedad->sincronizar($args);

           // Validacion
            $errores = $propiedad->validar();

           // Generar un nombre unico
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

           // Subida de archivos
            if ($_FILES['propiedad']['tmp_name']['imagen']) {
               // Realiza un resize a la imagen con intervention
                $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
                $propiedad->setImagen($nombreImagen);
            }

            if (empty($errores)) {

                if ($_FILES['propiedad']['tmp_name']['imagen']) {
                   // almacenar la imagen
                    $image->save(CARPETA_IMAGENES . $nombreImagen);
                }
    
                $resultado = $propiedad->Guardar();
            }
    
    }

        $router->render('propiedades/actualizar', [
            'propiedad' => $propiedad,
            'vendedores' => $vendedores,
            'errores' => $errores
        ]);
    }

    public static function eliminar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // validar id
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);
            if ($id) {
                $tipo = $_POST['tipo'];
                    if (validarTipoContenido($tipo)) {
                        $propiedad = Propiedad::find($id);
                        $propiedad->Eliminar();
                    }
            }
        }
    }
}