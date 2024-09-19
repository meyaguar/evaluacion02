# Proyecto de Gestión de Inventario

Este proyecto gestiona el inventario de productos, órdenes y proveedores. A continuación, se detallan los pasos para instalar y ejecutar el sistema, así como la estructura de los archivos involucrados.

## Instalación

### 1. Crear la base de datos

Ejecuta el archivo `01_schema.sql` para crear la estructura de la base de datos.

### 2. Insertar datos de prueba

Ejecuta el archivo `02_data.sql` para poblar la base de datos con datos de prueba.

### 3. Configurar variables de entorno

Crea un archivo `.env` con la configuración de la base de datos, como el nombre del servidor, nombre de la base de datos, usuario y contraseña.

### 4. Instalar dependencias

Si el proyecto tiene dependencias externas, asegúrate de instalarlas utilizando el gestor de paquetes correspondiente.

## Estructura de archivos

### Modelos

- `detalles_orden.model.php`: Modelo encargado de gestionar los detalles de las órdenes.
- `ordenes.model.php`: Modelo que maneja las operaciones relacionadas con las órdenes.
- `productos.model.php`: Modelo que gestiona la información de los productos.
- `proveedores.model.php`: Modelo encargado de la gestión de proveedores.

### Controladores

- `detalles_orden.controller.php`: Controlador que gestiona la lógica de los detalles de las órdenes.
- `ordenes.controller.php`: Controlador responsable de la gestión de las órdenes.
- `productos.controller.php`: Controlador que maneja las acciones relacionadas con los productos.
- `proveedores.controller.php`: Controlador que gestiona las acciones de los proveedores.

### Reporte

- `inventario.report.php`: Script que genera reportes relacionados con el inventario.

## Uso

Una vez configurado el entorno y la base de datos, el sistema estará listo para gestionar órdenes, productos, proveedores, y generar reportes de inventario.

