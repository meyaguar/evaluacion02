/**
 * Archivo: data.sql
 * Descripción: Script para agregar datos de prueba a la base de datos
 * Autor: YAGUAR, Eduardo 
 * Fecha: 17/09/2024
 */

-- Utilizar base de datos
USE eval02;

-- Truncar tablas
SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE Detalle_Orden;
TRUNCATE Ordenes_de_Compra;
TRUNCATE Productos;
TRUNCATE Proveedores;
SET FOREIGN_KEY_CHECKS = 1;

-- Insertar proveedores
INSERT INTO Proveedores (nombre, direccion, telefono, email) VALUES
  ('Proveedor 1', 'Calle 1', '123456789', 'proveedor1@evaluacion02.com'),
  ('Proveedor 2', 'Calle 2', '987654321', 'proveedor2@evaluacion02.com'),
  ('Proveedor 3', 'Calle 3', '555555555', 'proveedor3@evaluacion02.com'),
  ('Proveedor 4', 'Calle 4', '444444444', 'proveedor4@evaluacion02.com'),
  ('Proveedor 5', 'Calle 5', '333333333', 'proveedor5@evaluacion02.com');

-- Insertar productos
INSERT INTO Productos (nombre, descripcion, precio, stock) VALUES
  ('Producto 1', 'Descripción del producto 1', 10.99, 10),
  ('Producto 2', 'Descripción del producto 2', 5.99, 20),
  ('Producto 3', 'Descripción del producto 3', 7.99, 15),
  ('Producto 4', 'Descripción del producto 4', 12.99, 8),
  ('Producto 5', 'Descripción del producto 5', 9.99, 12),
  ('Producto 6', 'Descripción del producto 6', 6.99, 18),
  ('Producto 7', 'Descripción del producto 7', 11.99, 10),
  ('Producto 8', 'Descripción del producto 8', 8.99, 15),
  ('Producto 9', 'Descripción del producto 9', 13.99, 8),
  ('Producto 10', 'Descripción del producto 10', 10.99, 12);

-- Insertar órdenes de compra
INSERT INTO Ordenes_de_Compra (fecha, total, proveedor_id) VALUES
  ('2024-09-15', 100.00, 1),
  ('2024-09-16', 200.00, 2),
  ('2024-09-17', 150.00, 3),
  ('2024-09-18', 250.00, 4),
  ('2024-09-18', 300.00, 5);

-- Insertar detalles de órdenes
INSERT INTO Detalle_Orden (orden_id, producto_id, cantidad, precio_unitario) VALUES
  (1, 1, 2, 10.99),
  (1, 2, 3, 5.99),
  (2, 3, 4, 7.99),
  (2, 4, 2, 12.99),
  (3, 5, 1, 9.99),
  (3, 6, 3, 6.99),
  (4, 7, 2, 11.99),
  (4, 8, 4, 8.99),
  (5, 9, 1, 13.99),
  (5, 10, 3, 10.99);