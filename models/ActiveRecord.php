<?php

namespace Model;

class ActiveRecord {
        // Base de datos
        protected static $db;
        protected static $columnasDB = [];
        protected static $tabla = '';

        // Errores o Validacion
        protected static $errores = [];

        
        // definir la conexion a la BD
        public static function setDB($database) {
            self::$db = $database;
        }
    
        public function Guardar() {
            if (!is_null( $this->id )) {
                // actualizar
                $this->Actualizar();
            }else {
                // creando un nuevo registro
                $this->Crear();
            }
        }
        public function Crear() {
            // sanitizar los datos
            $atributos = $this->sanitizarAtributos();
    
            // insertar en la base de datos
            $query = " INSERT INTO " . static::$tabla . " ( ";
            $query .= join(', ', array_keys($atributos));
            $query .= " ) VALUES (' "; 
            $query .= join("', '", array_values($atributos));
            $query .= " '); ";
    
            $resultado = self::$db->query($query);
    
            if ($resultado) {
                // Redireccionando al usuario
                header('Location: /admin?resultado=1');
            }
        }
        public function Actualizar() {
            // sanitizar los datos
            $atributos = $this->sanitizarAtributos();
            $valores = [];
    
            foreach($atributos as $key => $value) {
                $valores[] = "{$key} ='{$value}'";
            }
            $query = " UPDATE " . static::$tabla . " SET ";
            $query .= join(', ', $valores);
            $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
            $query .= "LIMIT 1 ";
    
            $resultado = self::$db->query($query);
    
            if ($resultado) {
                // Redireccionando al usuario
                header('Location: /admin?resultado=2');
            }
    
        }
        // Eliminar un registro
        public function Eliminar() {
             // Elimina la registro
            $query = "DELETE FROM " . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
            $resultado = self::$db->query($query);
    
            if ($resultado) {
                $this->borrarImagen();
                header('Location: /admin?resultado=3');
            }
        }
        // identificar y unir los atributos de la BD
        public function Atributos() {
            $atributos = [];
            foreach(static::$columnasDB as $columna) {
                if($columna === 'id') continue;
                $atributos[$columna] = $this->$columna;
            }
            return $atributos;
        }
    
        public function sanitizarAtributos() {
            $atributos = $this->Atributos();
            $sanitizado = [];
    
            foreach($atributos as $key => $value ) {
                $sanitizado[$key] = self::$db->escape_string($value);
            }
    
            return $sanitizado;
        }
        // Subida de archivo
        public function setImagen($imagen) {
            // elimina la imagen previa
            if (!is_null( $this->id )) {
                $this->borrarImagen();
            }
            // asignar al atributo de imagen el nombre de la imagen
            if ($imagen) {
                $this->imagen = $imagen;
            }
        }
        // elimina el archivo
        public function borrarImagen() {
            // comprobar si existe el archivo
            $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
            if ($existeArchivo) {
                unlink(CARPETA_IMAGENES . $this->imagen);
            }
        }
    
        // Validacion
        public static function getErrores() {
            return static::$errores;
        }
        public function Validar() {
            static::$errores = [];
            return static::$errores;
        }
    
        // Lista todos los registros
        public static function all() {
            $query = "SELECT * FROM " . static::$tabla;
    
            $resultado = self::consultarSQL($query);
    
            return $resultado;
        }

        // obtiene determinado numero de registro
        public static function get($cantidad) {
            $query = "SELECT * FROM " . static::$tabla . " LIMIT " . $cantidad;
            
            $resultado = self::consultarSQL($query);
    
            return $resultado;
        }
    
        // busca un regristro por si id
        public static function find($id) {
            $query = "SELECT * FROM " . static::$tabla . " WHERE id = ${id}";
    
            $resultado = self::consultarSQL($query);
    
            return array_shift( $resultado );
        }
    
        public static function consultarSQL($query) {
            // consultar la base de datos
            $resultado = self::$db->query($query);
    
            // iterar los resultados
            $array = [];
            while($registro = $resultado->fetch_assoc()) {
                $array[] = static::crearObjeto($registro);
            }
    
            // liberar la memoria
            $resultado->free();
    
            // retornar los resultados
            return $array;
        }
    
        protected static function crearObjeto($registro) {
            $objeto = new static;
    
            foreach($registro as $key => $value) {
                if (property_exists($objeto, $key )) {
                    $objeto->$key = $value;
                }
            }
    
            return $objeto;
        }
    
        // sincronizar el objeto en memoria con los cambios realizados por el usuario 
        public function sincronizar( $args = [] ) {
            foreach($args as $key => $value) {
                if (property_exists($this, $key) && !is_null($value)) {
                    $this->$key = $value;
                }
            }
        }
}