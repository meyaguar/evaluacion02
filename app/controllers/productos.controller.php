<?php

/*
 * Archivo: productos.controller.php
 * Descripción: Controlador para el modelo productos.model
 * Autor: YAGUAR, Eduardo 
 * Fecha: 17/09/2024
 */

// Configuración de cabeceras CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

// Función para manejar errores
function handle_error($message) {
    http_response_code(500);
    echo json_encode(['error' => $message]);
    exit;
}

// Función para validar datos
function validate_data($data, $required_fields) {
    foreach ($required_fields as $field) {
        if (!isset($data[$field]) || empty($data[$field])) {
            handle_error("Campo '$field' es requerido");
        }
    }
}

// Inclusión del modelo de Producto
require_once __DIR__ . '/../models/productos.model.php';

// Creación de instancia de Producto
$productos = new Productos();

// Obtención del método de solicitud
$method = isset($_SERVER["REQUEST_METHOD"]) ? $_SERVER["REQUEST_METHOD"] : null;

// Manejo de la solicitud OPTIONS
if ($method === "OPTIONS") {
    die();
}

// Obtención de la operación
$op = isset($_GET["op"]) ? $_GET["op"] : null;

// Manejo de operaciones CRUD
switch ($op) {
    case 'todos':
        try {
            // Obtener todos los productos
            $datos = $productos->todos();
            echo json_encode($datos->fetch_all(MYSQLI_ASSOC));
        } catch (Exception $e) {
            handle_error($e->getMessage());
        }
        break;

    case 'uno':
        try {
            // Obtener un producto por ID
            validate_data($_POST, ['producto_id']);
            $producto_id = $_POST["producto_id"];
            $datos = $productos->uno($producto_id);
            echo json_encode($datos->fetch_assoc());
        } catch (Exception $e) {
            handle_error($e->getMessage());
        }
        break;

    case 'insertar':
        try {
            // Insertar un nuevo producto
            validate_data($_POST, ['nombre', 'descripcion', 'precio', 'stock']);
            $datos = $productos->insertar(
                $_POST["nombre"],
                $_POST["descripcion"],
                $_POST["precio"],
                $_POST["stock"]
            );
            echo json_encode($datos);
        } catch (Exception $e) {
            handle_error($e->getMessage());
        }
        break;

    case 'actualizar':
        try {
            // Actualizar un producto existente
            validate_data($_POST, ['producto_id', 'nombre', 'descripcion', 'precio', 'stock']);
            $datos = $productos->actualizar(
                $_POST["producto_id"],
                $_POST["nombre"],
                $_POST["descripcion"],
                $_POST["precio"],
                $_POST["stock"]
            );
            echo json_encode($datos);
        } catch (Exception $e) {
            handle_error($e->getMessage());
        }
        break;

    case 'eliminar':
        try {
            // Eliminar un producto
            validate_data($_POST, ['producto_id']);
            $datos = $productos->eliminar($_POST["producto_id"]);
            echo json_encode($datos);
        } catch (Exception $e) {
            handle_error($e->getMessage());
        }
        break;

    default:
        handle_error("Operación no válida");
        break;
}