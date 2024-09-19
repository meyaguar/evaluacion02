# SEMANA 05 - TAREA 1

## Descripción

Esta tarea consiste en la implementación de los procedimientos necesarios para realizar las operaciones de `Update` y `Delete` en facturas, utilizando Angular en el frontend y PHP en el backend. La tarea se basa en los conceptos y ejercicios desarrollados en clase.

## Instrucciones de la Actividad

1. **Edición de Angular.JSON**:
   - Se agregó la librería `sweetalert2` en `allowedCommonJsDependencies` para manejar las alertas de confirmación en las operaciones de actualización y eliminación.

   ```json
   "root": "",
   "sourceRoot": "src",
   "prefix": "app",
   "architect": {
     "build": {
       "builder": "@angular-devkit/build-angular:browser",
       "options": {
         "allowedCommonJsDependencies": ["bezier-easing", "apexcharts", "sweetalert2"],
         "outputPath": "dist",
         "index": "src/index.html",
         "main": "src/main.ts",
         "polyfills": "src/polyfills.ts",
         "tsConfig": "tsconfig.app.json",
         "inlineStyleLanguage": "scss",
         "assets": ["src/favicon.ico", "src/assets"],
         "styles": ["src/styles.scss"],
         "scripts": []
       }
     }
   }
2. **Implementación en `facturas.components.ts`**:

   Eliminar Factura: Se implementó un método para eliminar una factura mediante una confirmación de usuario utilizando SweetAlert2.  
   Actualizar Factura: Se implementó un método para actualizar una factura mediante una confirmación de usuario utilizando SweetAlert2.   
   
   ```typescript
   //SEMANA 05 - TAREA 1
   //DELETE DE FACTURAS

   eliminar(idFactura: number) {
     Swal.fire({
       title: 'Facturas',
       text: '¿Está seguro de que desea eliminar la factura?',
       icon: 'warning',
       showCancelButton: true,
       confirmButtonColor: '#d33',
       cancelButtonColor: '#3085d6',
       confirmButtonText: 'Eliminar Factura'
     }).then((result) => {
       if (result.isConfirmed) {
         this.facturaServicio.eliminar(idFactura).pipe(
           tap((response) => {
             if (response === 1) { 
               Swal.fire('Facturas', 'La factura ha sido eliminada.', 'success');
               this.cargatabla(); 
             } else {
               Swal.fire('Error', 'No se pudo eliminar la factura.', 'error');
             }
           }),
           catchError((error) => {
             console.error('Error al eliminar la factura:', error);
             Swal.fire('Error', 'Ocurrió un problema al eliminar la factura.', 'error');
             return of();  
           })
         ).subscribe();
       }
     });
   }

   //SEMANA 05 - TAREA 1
   //UPDATE DE FACTURAS

   actualizar(factura: IFactura) {
     console.log('Actualizar factura:', factura);
     this.router.navigate(['editarfactura', factura.idFactura]);
   } 
4. **Implementación en `Factura.service.ts`**:

   Eliminar Factura: Método para eliminar una factura en el servidor.  
   Actualizar Factura: Método para actualizar los datos de una factura.

   ```typescript
   //SEMANA 05 - TAREA 1
   //DELETE DE FACTURAS
   eliminar(idFactura: number): Observable<number> {
     const formData = new FormData();
     formData.append('idFactura', idFactura.toString());
     return this.lector.post<number>(this.apiurl + 'eliminar', formData);
   }

   //SEMANA 05 - TAREA 1
   //UPDATE DE FACTURAS

   actualizar(factura: IFactura): Observable<string> {
     const formData = new FormData();
     formData.append('idFactura', factura.idFactura.toString());
     formData.append('Fecha', factura.Fecha);
     formData.append('Sub_total', factura.Sub_total.toString());
     formData.append('Sub_total_iva', factura.Sub_total_iva.toString());
     formData.append('Valor_IVA', factura.Valor_IVA.toString());
     formData.append('Clientes_idClientes', factura.Clientes_idClientes.toString());
     return this.lector.post<string>(this.apiurl + 'actualizar', formData);
   }


## Instalación

1. Clona este repositorio.
2. Instala las dependencias con `npm install -g @angular/cli`. 
   Si se requiere actualizar el core:  `ng update @angular/core @angular/cli`
3. Configura el backend en PHP siguiendo los requisitos de la API.
4. Ejecuta la aplicación con `ng serve`.
