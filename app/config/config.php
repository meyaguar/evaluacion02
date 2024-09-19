<?php
/*
 * Archivo: config.php
 * Descripción: Clase para conectarse a la base de datos utilizando mysqli
 * Autor: YAGUAR, Eduardo 
 * Fecha: 17/09/2024
 */

// Cargar archivo de configuración
$config = parse_ini_file(dirname(__DIR__, 1) . '/.env');

class ClaseConectar
{
    // Variables estáticas para almacenar la configuración de la base de datos
    private static $HOST;
    private static $USUARIO;        
    private static $PASS;
    private static $BASE;

    // Método para inicializar las variables estáticas con los valores de la configuración
    public static function init()
    {
        self::$HOST = $GLOBALS['config']['DB_HOST'];
        self::$USUARIO = $GLOBALS['config']['DB_USER'];
        self::$PASS = $GLOBALS['config']['DB_PASS'];
        self::$BASE = $GLOBALS['config']['DB_NAME'];
    }

    // Método para conectarse a la base de datos
    public function conectar()
    {
        // Inicializar variables estáticas
        self::init();

        // Crear objeto de conexión
        $conexion = new mysqli(self::$HOST, self::$USUARIO, self::$PASS, self::$BASE);

        // Manejar errores de conexión
        if ($conexion->connect_error) {
            // Error de credenciales
            if (strpos($conexion->connect_error, "Access denied") !== false) {
                throw new Exception("Error de credenciales: Verifique el nombre de usuario y contraseña.");
            }
            // Error de base de datos no encontrada
            elseif (strpos($conexion->connect_error, "Unknown database") !== false) {
                throw new Exception("Error de base de datos no encontrada: Verifique el nombre de la base de datos.");
            }
            // Otro error
            else {
                throw new Exception("Error al conectar con el servidor: " . $conexion->connect_error);
            }
        }

        // Establecer codificación de caracteres
        $conexion->set_charset("utf8");

        // Retornar objeto de conexión
        return $conexion;
    }
}