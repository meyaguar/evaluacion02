<?php

/*
 * Archivo: detalle-orden.model.php
 * Descripción: Modelo de 'detalles de orden'
 * Autor: YAGUAR, Eduardo 
 * Fecha: 17/09/2024
 */

require_once __DIR__ . '/../config/config.php';

class DetallesOrden
{
    private $con;

    // Establecer conexión a la base de datos en el constructor
    public function __construct()
    {
        $this->con = (new ClaseConectar())->conectar();
    }

    // Obtener todos los detalles de orden de la base de datos
    public function todos()
    {
        try {
            $query = "SELECT do.detalle_id, o.orden_id, p.producto_id, p.nombre AS producto_nombre, do.cantidad, do.precio_unitario 
                      FROM Detalle_Orden do 
                      INNER JOIN Ordenes_de_Compra o ON do.orden_id = o.orden_id 
                      INNER JOIN Productos p ON do.producto_id = p.producto_id";
            $stmt = $this->con->prepare($query);
            $stmt->execute();
            return $stmt->get_result();
        } catch (Exception $th) {
            throw new Exception("Error al obtener detalles de orden: " . $th->getMessage());
        } finally {
            $this->con->close();
        }
    }

    // Obtener un detalle de orden por ID de la base de datos
    public function uno($detalle_id)
    {
        try {
            $query = "SELECT do.detalle_id, o.orden_id, p.producto_id, p.nombre AS producto_nombre, do.cantidad, do.precio_unitario 
                      FROM Detalle_Orden do 
                      INNER JOIN Ordenes_de_Compra o ON do.orden_id = o.orden_id 
                      INNER JOIN Productos p ON do.producto_id = p.producto_id 
                      WHERE do.detalle_id = ?";
            $stmt = $this->con->prepare($query);
            $stmt->bind_param("i", $detalle_id);
            $stmt->execute();
            return $stmt->get_result();
        } catch (Exception $th) {
            throw new Exception("Error al obtener detalle de orden: " . $th->getMessage());
        } finally {
            $this->con->close();
        }
    }

    // Obtener todos los detalles de una orden específica
    public function todosPorOrden($orden_id)
    {
        try {
            $query = "SELECT do.detalle_id, o.orden_id, p.producto_id, p.nombre AS producto_nombre, do.cantidad, do.precio_unitario 
                      FROM Detalle_Orden do 
                      INNER JOIN Ordenes_de_Compra o ON do.orden_id = o.orden_id 
                      INNER JOIN Productos p ON do.producto_id = p.producto_id 
                      WHERE do.orden_id = ?";
            $stmt = $this->con->prepare($query);
            $stmt->bind_param("i", $orden_id);
            $stmt->execute();
            return $stmt->get_result();
        } catch (Exception $th) {
            throw new Exception("Error al obtener detalles de orden: " . $th->getMessage());
        } finally {
            $this->con->close();
        }
    }

    // Insertar un nuevo detalle de orden en la base de datos
    public function insertar($orden_id, $producto_id, $cantidad, $precio_unitario)
    {
        try {
            $query = "INSERT INTO Detalle_Orden (orden_id, producto_id, cantidad, precio_unitario) VALUES (?, ?, ?, ?)";
            $stmt = $this->con->prepare($query);
            $stmt->bind_param("iiid", $orden_id, $producto_id, $cantidad, $precio_unitario);
            $stmt->execute();
            return $this->con->insert_id;
        } catch (Exception $th) {
            throw new Exception("Error al insertar detalle de orden: " . $th->getMessage());
        } finally {
            $this->con->close();
        }
    }

    // Actualizar un detalle de orden existente en la base de datos
    public function actualizar($detalle_id, $cantidad, $precio_unitario)
    {
        try {
            $query = "UPDATE Detalle_Orden SET cantidad = ?, precio_unitario = ? WHERE detalle_id = ?";
            $stmt = $this->con->prepare($query);
            $stmt->bind_param("idi", $cantidad, $precio_unitario, $detalle_id);
            $stmt->execute();
            return $detalle_id;
        } catch (Exception $th) {
            throw new Exception("Error al actualizar detalle de orden: " . $th->getMessage());
        } finally {
            $this->con->close();
        }
    }

    // Eliminar un detalle de orden de la base de datos
    public function eliminar($detalle_id)
    {
        try {
            $query = "DELETE FROM Detalle_Orden WHERE detalle_id = ?";
            $stmt = $this->con->prepare($query);
            $stmt->bind_param("i", $detalle_id);
            $stmt->execute();
            return 1;
        } catch (Exception $th) {
            throw new Exception("Error al eliminar detalle de orden: " . $th->getMessage());
        } finally {
            $this->con->close();
        }
    }

    // Obtener el total de una orden específica
    public function totalOrden($orden_id)
    {
        try {
            $query = "SELECT SUM(do.cantidad * do.precio_unitario) AS total 
                    FROM Detalle_Orden do 
                    WHERE do.orden_id = ?";
            $stmt = $this->con->prepare($query);
            $stmt->bind_param("i", $orden_id);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_assoc()['total'];
        } catch (Exception $th) {
            throw new Exception("Error al obtener total de orden: " . $th->getMessage());
        } finally {
            $this->con->close();
        }
    }
}