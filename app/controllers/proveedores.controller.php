<?php

/*
 * Archivo: proveedores.controller.php
 * Descripción: Controlador para el modelo proveedores.model
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

// Inclusión del modelo de Proveedor
require_once __DIR__ . '/../models/proveedores.model.php';

// Creación de instancia de Proveedor
$proveedores = new Proveedores();

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
            // Obtener todos los proveedores
            $datos = $proveedores->todos();
            echo json_encode($datos->fetch_all(MYSQLI_ASSOC));
        } catch (Exception $e) {
            handle_error($e->getMessage());
        }
        break;

    case 'uno':
        try {
            // Obtener un proveedor por ID
            validate_data($_POST, ['proveedor_id']);
            $proveedor_id = $_POST["proveedor_id"];
            $datos = $proveedores->uno($proveedor_id);
            echo json_encode($datos->fetch_assoc());
        } catch (Exception $e) {
            handle_error($e->getMessage());
        }
        break;

    case 'insertar':
        try {
            // Insertar un nuevo proveedor
            validate_data($_POST, ['nombre', 'direccion', 'telefono', 'email']);
            $datos = $proveedores->insertar(
                $_POST["nombre"],
                $_POST["direccion"],
                $_POST["telefono"],
                $_POST["email"]
            );
            echo json_encode($datos);
        } catch (Exception $e) {
            handle_error($e->getMessage());
        }
        break;

    case 'actualizar':
        try {
            // Actualizar un proveedor existente
            validate_data($_POST, ['proveedor_id', 'nombre', 'direccion', 'telefono', 'email']);
            $datos = $proveedores->actualizar(
                $_POST["proveedor_id"],
                $_POST["nombre"],
                $_POST["direccion"],
                $_POST["telefono"],
                $_POST["email"]
            );
            echo json_encode($datos);
        } catch (Exception $e) {
            handle_error($e->getMessage());
        }
        break;

    case 'eliminar':
        try {
            // Eliminar un proveedor
            validate_data($_POST, ['proveedor_id']);
            $datos = $proveedores->eliminar($_POST["proveedor_id"]);
            echo json_encode($datos);
        } catch (Exception $e) {
            handle_error($e->getMessage());
        }
        break;

    default:
        handle_error("Operación no válida");
        break;
}