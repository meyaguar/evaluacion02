import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { IProducto } from '../Interfaces/iproducto';

@Injectable({
  providedIn: 'root'
})
export class ProductoService {
  apiurl = 'http://localhost/evaluacion02/app/controllers/productos.controller.php?op=';

  constructor(private lector: HttpClient) {}

  todos(): Observable<IProducto[]> {
    return this.lector.get<IProducto[]>(this.apiurl + 'todos');
  }

  uno(producto_id: number): Observable<IProducto> {
    const formData = new FormData();
    formData.append('producto_id', producto_id.toString());
    return this.lector.post<IProducto>(this.apiurl + 'uno', formData);
  }

  eliminar(producto_id: number): Observable<number> {
    const formData = new FormData();
    formData.append('producto_id', producto_id.toString());
    return this.lector.post<number>(this.apiurl + 'eliminar', formData);
  }

  insertar(producto: IProducto): Observable<string> {
    const formData = new FormData();
    formData.append('nombre', producto.nombre);
    formData.append('descripcion', producto.descripcion);
    formData.append('precio', producto.precio.toString());
    formData.append('stock', producto.stock.toString());
    return this.lector.post<string>(this.apiurl + 'insertar', formData);
  }

  actualizar(producto: IProducto): Observable<string> {
    const formData = new FormData();
    formData.append('producto_id', producto.producto_id.toString());
    formData.append('nombre', producto.nombre);
    formData.append('descripcion', producto.descripcion);
    formData.append('precio', producto.precio.toString());
    formData.append('stock', producto.stock.toString());
    return this.lector.post<string>(this.apiurl + 'actualizar', formData);
  }
}