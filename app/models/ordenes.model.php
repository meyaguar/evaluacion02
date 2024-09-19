<?php

/*
 * Archivo: orden.model.php
 * Descripción: Modelo de 'ordenes'
 * Autor: YAGUAR, Eduardo 
 * Fecha: 17/09/2024
 */

require_once __DIR__ . '/../config/config.php';

class Ordenes
{
    private $con;

    // Establecer conexión a la base de datos en el constructor
    public function __construct()
    {
        $this->con = (new ClaseConectar())->conectar();
    }

    // Obtener todas las órdenes de la base de datos
    public function todos()
    {
        try {
            $query = "SELECT o.orden_id, o.fecha, o.total, p.proveedor_id, p.nombre AS proveedor_nombre 
                      FROM Ordenes_de_Compra o 
                      INNER JOIN Proveedores p ON o.proveedor_id = p.proveedor_id";
            $stmt = $this->con->prepare($query);
            $stmt->execute();
            return $stmt->get_result();
        } catch (Exception $th) {
            throw new Exception("Error al obtener órdenes: " . $th->getMessage());
        } finally {
            $this->con->close();
        }
    }

    // Obtener una orden por ID de la base de datos
    public function uno($orden_id)
    {
        try {
            $query = "SELECT o.orden_id, o.fecha, o.total, p.proveedor_id, p.nombre AS proveedor_nombre 
                      FROM Ordenes_de_Compra o 
                      INNER JOIN Proveedores p ON o.proveedor_id = p.proveedor_id 
                      WHERE o.orden_id = ?";
            $stmt = $this->con->prepare($query);
            $stmt->bind_param("i", $orden_id);
            $stmt->execute();
            return $stmt->get_result();
        } catch (Exception $th) {
            throw new Exception("Error al obtener orden: " . $th->getMessage());
        } finally {
            $this->con->close();
        }
    }

    // Insertar una nueva orden en la base de datos
    public function insertar($fecha, $total, $proveedor_id)
    {
        try {
            $query = "INSERT INTO Ordenes_de_Compra (fecha, total, proveedor_id) VALUES (?, ?, ?)";
            $stmt = $this->con->prepare($query);
            $stmt->bind_param("sdi", $fecha, $total, $proveedor_id);
            $stmt->execute();
            return $this->con->insert_id;
        } catch (Exception $th) {
            throw new Exception("Error al insertar orden: " . $th->getMessage());
        } finally {
            $this->con->close();
        }
    }

    // Actualizar una orden existente en la base de datos
    public function actualizar($orden_id, $fecha, $total, $proveedor_id)
    {
        try {
            $query = "UPDATE Ordenes_de_Compra SET fecha = ?, total = ?, proveedor_id = ? WHERE orden_id = ?";
            $stmt = $this->con->prepare($query);
            $stmt->bind_param("sdii", $fecha, $total, $proveedor_id, $orden_id);
            $stmt->execute();
            return $orden_id;
        } catch (Exception $th) {
            throw new Exception("Error al actualizar orden: " . $th->getMessage());
        } finally {
            $this->con->close();
        }
    }

    // Eliminar una orden de la base de datos
    public function eliminar($orden_id)
    {
        try {
            $query = "DELETE FROM Ordenes_de_Compra WHERE orden_id = ?";
            $stmt = $this->con->prepare($query);
            $stmt->bind_param("i", $orden_id);
            $stmt->execute();
            return 1;
        } catch (Exception $th) {
            throw new Exception("Error al eliminar orden: " . $th->getMessage());
        } finally {
            $this->con->close();
        }
    }
}