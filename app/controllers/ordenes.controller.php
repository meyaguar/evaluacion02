<?php

/*
 * Archivo: ordenes.controller.php
 * Descripción: Controlador para el modelo ordenes.model
 * Autor: YAGUAR, Eduardo 
 * Fecha: 18/09/2024
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

// Inclusión del modelo de Orden
require_once __DIR__ . '/../models/ordenes.model.php';

// Creación de instancia de Orden
$ordenes = new Ordenes();

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
            // Obtener todas las órdenes
            $datos = $ordenes->todos();
            echo json_encode($datos->fetch_all(MYSQLI_ASSOC));
        } catch (Exception $e) {
            handle_error($e->getMessage());
        }
        break;

    case 'uno':
        try {
            // Obtener una orden por ID
            validate_data($_POST, ['orden_id']);
            $orden_id = $_POST["orden_id"];
            $datos = $ordenes->uno($orden_id);
            echo json_encode($datos->fetch_assoc());
        } catch (Exception $e) {
            handle_error($e->getMessage());
        }
        break;

    case 'insertar':
        try {
            // Insertar una nueva orden
            validate_data($_POST, ['fecha', 'total', 'proveedor_id']);
            $datos = $ordenes->insertar(
                $_POST["fecha"],
                $_POST["total"],
                $_POST["proveedor_id"]
            );
            echo json_encode($datos);
        } catch (Exception $e) {
            handle_error($e->getMessage());
        }
        break;

    case 'actualizar':
        try {
            // Actualizar una orden existente
            validate_data($_POST, ['orden_id', 'fecha', 'total', 'proveedor_id']);
            $datos = $ordenes->actualizar(
                $_POST["orden_id"],
                $_POST["fecha"],
                $_POST["total"],
                $_POST["proveedor_id"]
            );
            echo json_encode($datos);
        } catch (Exception $e) {
            handle_error($e->getMessage());
        }
        break;

    case 'eliminar':
        try {
            // Eliminar una orden
            validate_data($_POST, ['orden_id']);
            $datos = $ordenes->eliminar($_POST["orden_id"]);
            echo json_encode($datos);
        } catch (Exception $e) {
            handle_error($e->getMessage());
        }
        break;

    default:
        handle_error("Operación no válida");
        break;
}