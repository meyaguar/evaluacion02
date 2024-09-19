/**
 * Archivo: schema.sql
 * Descripción: Script crear la base de datos
 * Autor: YAGUAR, Eduardo 
 * Fecha: 17/09/2024
 */

-- Crear base de datos
CREATE DATABASE IF NOT EXISTS eval02;

-- Utilizar base de datos
USE eval02;

-- Crear tabla Proveedores
CREATE TABLE Proveedores (
  proveedor_id INT AUTO_INCREMENT,
  nombre VARCHAR(100) NOT NULL,
  direccion VARCHAR(200) NOT NULL,
  telefono VARCHAR(20) NOT NULL,
  email VARCHAR(100) UNIQUE NOT NULL,
  PRIMARY KEY (proveedor_id)
);

-- Crear tabla Productos
CREATE TABLE Productos (
  producto_id INT AUTO_INCREMENT,
  nombre VARCHAR(100) NOT NULL,
  descripcion TEXT,
  precio DECIMAL(10, 2) NOT NULL,
  stock INT NOT NULL DEFAULT 0,
  PRIMARY KEY (producto_id)
);


-- Crear tabla Ordenes_de_Compra
CREATE TABLE Ordenes_de_Compra (
  orden_id INT AUTO_INCREMENT,
  fecha DATE NOT NULL,
  total DECIMAL(10, 2) NOT NULL,
  proveedor_id INT,
  PRIMARY KEY (orden_id),
  FOREIGN KEY (proveedor_id) REFERENCES Proveedores(proveedor_id)
);

-- Crear tabla Detalle_Orden
CREATE TABLE Detalle_Orden (
  detalle_id INT AUTO_INCREMENT,
  orden_id INT,
  producto_id INT,
  cantidad INT NOT NULL,
  precio_unitario DECIMAL(10, 2) NOT NULL,
  PRIMARY KEY (detalle_id),
  FOREIGN KEY (orden_id) REFERENCES Ordenes_de_Compra(orden_id) ON DELETE CASCADE,
  FOREIGN KEY (producto_id) REFERENCES Productos(producto_id) ON DELETE RESTRICT
);