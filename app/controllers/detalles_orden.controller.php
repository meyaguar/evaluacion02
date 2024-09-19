<?php

/*
 * Archivo: detalles_orden.controller.php
 * Descripción: Controlador para el modelo detalles_orden.model
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

// Inclusión del modelo de DetallesOrden
require_once __DIR__ . '/../models/detalles_orden.model.php';

// Creación de instancia de DetallesOrden
$detalles_orden = new DetallesOrden();

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
            // Obtener todos los detalles de orden
            $datos = $detalles_orden->todos();
            echo json_encode($datos->fetch_all(MYSQLI_ASSOC));
        } catch (Exception $e) {
            handle_error($e->getMessage());
        }
        break;

    case 'uno':
        try {
            // Obtener un detalle de orden por ID
            validate_data($_POST, ['detalle_id']);
            $detalle_id = $_POST["detalle_id"];
            $datos = $detalles_orden->uno($detalle_id);
            echo json_encode($datos->fetch_assoc());
        } catch (Exception $e) {
            handle_error($e->getMessage());
        }
        break;

    case 'todosPorOrden':
        try {
            // Obtener todos los detalles de una orden específica
            validate_data($_POST, ['orden_id']);
            $orden_id = $_POST["orden_id"];
            $datos = $detalles_orden->todosPorOrden($orden_id);
            echo json_encode($datos->fetch_all(MYSQLI_ASSOC));
        } catch (Exception $e) {
            handle_error($e->getMessage());
        }
        break;

    case 'insertar':
        try {
            // Insertar un nuevo detalle de orden
            validate_data($_POST, ['orden_id', 'producto_id', 'cantidad', 'precio_unitario']);
            $datos = $detalles_orden->insertar(
                $_POST["orden_id"],
                $_POST["producto_id"],
                $_POST["cantidad"],
                $_POST["precio_unitario"]
            );
            echo json_encode($datos);
        } catch (Exception $e) {
            handle_error($e->getMessage());
        }
        break;

    case 'actualizar':
        try {
            // Actualizar un detalle de orden existente
            validate_data($_POST, ['detalle_id', 'orden_id', 'producto_id', 'cantidad', 'precio_unitario']);
            $datos = $detalles_orden->actualizar(
                $_POST["detalle_id"],
                $_POST["orden_id"],
                $_POST["producto_id"],
                $_POST["cantidad"],
                $_POST["precio_unitario"]
            );
            echo json_encode($datos);
        } catch (Exception $e) {
            handle_error($e->getMessage());
        }
        break;

    case 'eliminar':
        try {
            // Eliminar un detalle de orden
            validate_data($_POST, ['detalle_id']);
            $datos = $detalles_orden->eliminar($_POST["detalle_id"]);
            echo json_encode($datos);
        } catch (Exception $e) {
            handle_error($e->getMessage());
        }
        break;

    case 'totalOrden':
        try {
            // Obtener el total de una orden específica
            validate_data($_POST, ['orden_id']);
            $orden_id = $_POST["orden_id"];
            $datos = $detalles_orden->totalOrden($orden_id);
            echo json_encode($datos);
        } catch (Exception $e) {
            handle_error($e->getMessage());
        }
        break;

    default:
        handle_error("Operación no válida");
        break;
}
