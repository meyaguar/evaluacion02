<?php

/*
 * Archivo: productos.model.php
 * Descripción: Modelo de 'productos'
 * Autor: YAGUAR, Eduardo 
 * Fecha: 17/09/2024
 */

//require_once('../config/config.php');
require_once __DIR__ . '/../config/config.php';

class Productos
{
    private $con;

    // Establecer conexión a la base de datos en el constructor
    public function __construct()
    {
        $this->con = (new ClaseConectar())->conectar();
    }

    // Obtener todos los productos de la base de datos
    public function todos()
    {
        try {
            $query = "SELECT * FROM productos";
            $stmt = $this->con->prepare($query);
            $stmt->execute();
            return $stmt->get_result();
        } catch (Exception $th) {
            throw new Exception("Error al obtener productos: " . $th->getMessage());
        } finally {
            $this->con->close();
        }
    }

    // Obtener un producto por ID de la base de datos
    public function uno($producto_id)
    {
        try {
            $query = "SELECT * FROM productos WHERE producto_id = ?";
            $stmt = $this->con->prepare($query);
            $stmt->bind_param("i", $producto_id);
            $stmt->execute();
            return $stmt->get_result();
        } catch (Exception $th) {
            throw new Exception("Error al obtener producto: " . $th->getMessage());
        } finally {
            $this->con->close();
        }
    }

    // Insertar un nuevo producto en la base de datos
    // HACK: 'stock' en la bd es un campo int
    public function insertar($nombre, $descripcion, $precio, $stock)
    {
        try {
            $query = "INSERT INTO productos (nombre, descripcion, precio, stock) VALUES (?, ?, ?, ?)";
            $stmt = $this->con->prepare($query);
            $stmt->bind_param("ssdi", $nombre, $descripcion, $precio, $stock);
            $stmt->execute();
            return $this->con->insert_id;
        } catch (Exception $th) {
            throw new Exception("Error al insertar producto: " . $th->getMessage());
        } finally {
            $this->con->close();
        }
    }

    // Actualizar un producto existente en la base de datos
    public function actualizar($producto_id,$nombre, $descripcion, $precio, $stock)
    {
        try {
            $query = "UPDATE productos SET nombre = ?, descripcion = ?, precio = ?, stock = ? WHERE producto_id = ?";
            $stmt = $this->con->prepare($query);
            $stmt->bind_param("ssdii", $nombre, $descripcion, $precio, $stock, $producto_id);
            $stmt->execute();
            return $producto_id;
        } catch (Exception $th) {
            throw new Exception("Error al actualizar producto: " . $th->getMessage());
        } finally {
            $this->con->close();
        }
    }

    // Eliminar un producto de la base de datos
    public function eliminar($producto_id)
    {
        try {
            $query = "DELETE FROM productos WHERE producto_id = ?";
            $stmt = $this->con->prepare($query);
            $stmt->bind_param("i", $producto_id);
            $stmt->execute();
            return 1;
        } catch (Exception $th) {
            throw new Exception("Error al eliminar producto: " . $th->getMessage());
        } finally {
            $this->con->close();
        }
    }
}