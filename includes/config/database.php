<?php

function conectarDB(): mysqli {
    // Cargar el archivo .env
    $env = parse_ini_file(__DIR__ . '/../../.env');

    // Extraer variables del entorno
    $host = $env['DB_HOST'] ;
    $user = $env['DB_USER'] ;
    $pass = $env['DB_PASS'] ;
    $name = $env['DB_NAME'] ;

    // Conectar a la base de datos
    $db = new mysqli($host, $user, $pass, $name);

    if ($db->connect_error) {
        echo "Error: no se pudo conectar - " . $db->connect_error;
        exit;
    }

    return $db;
}
