<?php

/*
 * Archivo: proveedores.model.php
 * Descripción: Modelo de 'proveedores'
 * Autor: YAGUAR, Eduardo 
 * Fecha: 17/09/2024
 */

require_once __DIR__ . '/../config/config.php';

class Proveedores
{
    private $con;

    // Establecer conexión a la base de datos en el constructor
    public function __construct()
    {
        $this->con = (new ClaseConectar())->conectar();
    }

    // Obtener todos los proveedores de la base de datos
    public function todos()
    {
        try {
            $query = "SELECT * FROM proveedores";
            $stmt = $this->con->prepare($query);
            $stmt->execute();
            return $stmt->get_result();
        } catch (Exception $th) {
            throw new Exception("Error al obtener proveedores: " . $th->getMessage());
        } finally {
            $this->con->close();
        }
    }

    // Obtener un proveedor por ID de la base de datos
    public function uno($proveedor_id)
    {
        try {
            $query = "SELECT * FROM proveedores WHERE proveedor_id = ?";
            $stmt = $this->con->prepare($query);
            $stmt->bind_param("i", $proveedor_id);
            $stmt->execute();
            return $stmt->get_result();
        } catch (Exception $th) {
            throw new Exception("Error al obtener proveedor: " . $th->getMessage());
        } finally {
            $this->con->close();
        }
    }

    // Insertar un nuevo proveedor en la base de datos
    public function insertar($nombre, $direccion, $telefono, $email)
    {
        try {
            $query = "INSERT INTO proveedores (nombre, direccion, telefono, email) VALUES (?, ?, ?, ?)";
            $stmt = $this->con->prepare($query);
            $stmt->bind_param("ssss", $nombre, $direccion, $telefono, $email);
            $stmt->execute();
            return $this->con->insert_id;
        } catch (Exception $th) {
            throw new Exception("Error al insertar proveedor: " . $th->getMessage());
        } finally {
            $this->con->close();
        }
    }

    // Actualizar un proveedor existente en la base de datos
    public function actualizar($proveedor_id, $nombre, $direccion, $telefono, $email)
    {
        try {
            $query = "UPDATE proveedores SET nombre = ?, direccion = ?, telefono = ?, email = ? WHERE proveedor_id = ?";
            $stmt = $this->con->prepare($query);
            $stmt->bind_param("ssssi", $nombre, $direccion, $telefono, $email, $proveedor_id);
            $stmt->execute();
            return $proveedor_id;
        } catch (Exception $th) {
            throw new Exception("Error al actualizar proveedor: " . $th->getMessage());
        } finally {
            $this->con->close();
        }
    }

    // Eliminar un proveedor de la base de datos
    public function eliminar($proveedor_id)
    {
        try {
            $query = "DELETE FROM proveedores WHERE proveedor_id = ?";
            $stmt = $this->con->prepare($query);
            $stmt->bind_param("i", $proveedor_id);
            $stmt->execute();
            return 1;
        } catch (Exception $th) {
            throw new Exception("Error al eliminar proveedor: " . $th->getMessage());
        } finally {
            $this->con->close();
        }
    }
}