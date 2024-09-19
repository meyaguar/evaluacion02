import { Component, OnInit } from '@angular/core';
import { FormControl, FormGroup, FormsModule, ReactiveFormsModule, Validators } from '@angular/forms';
import { Router, ActivatedRoute } from '@angular/router';
import { IFactura } from 'src/app/Interfaces/factura';
import { ICliente } from 'src/app/Interfaces/icliente';
import { ClientesService } from 'src/app/Services/clientes.service';
import { FacturaService } from 'src/app/Services/factura.service';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-nuevafactura',
  standalone: true,
  imports: [FormsModule, ReactiveFormsModule, CommonModule],
  templateUrl: './nuevafactura.component.html',
  styleUrls: ['./nuevafactura.component.scss']
})
export class NuevafacturaComponent implements OnInit {
  titulo = 'Nueva Factura';
  listaClientes: ICliente[] = [];
  listaClientesFiltrada: ICliente[] = [];
  totalapagar: number = 0;
  frm_factura: FormGroup;
  idFactura: number;

  constructor(
    private clientesServicios: ClientesService,
    private facturaService: FacturaService,
    private navegacion: Router,
    private rutaActiva: ActivatedRoute
  ) {}

  ngOnInit(): void {
    this.frm_factura = new FormGroup({
      Fecha: new FormControl('', Validators.required),
      Sub_total: new FormControl('', Validators.required),
      Sub_total_iva: new FormControl('', Validators.required),
      Valor_IVA: new FormControl('0.15', Validators.required),
      Clientes_idClientes: new FormControl('', Validators.required)
    });

    this.clientesServicios.todos().subscribe({
      next: (data) => {
        this.listaClientes = data;
        this.listaClientesFiltrada = data;
      },
      error: (e) => {
        console.log(e);
      }
    });

    this.idFactura = this.rutaActiva.snapshot.params['id'];
    if (this.idFactura) {
      this.facturaService.uno(this.idFactura).subscribe({
        next: (factura: IFactura) => {
          console.log('Datos de la factura cargada:', factura);
          this.titulo = 'Actualizar Factura';
          this.frm_factura.patchValue({
            Fecha: new Date(factura.Fecha).toISOString().split('T')[0], // Asegura que la fecha tenga el formato correcto
            Sub_total: factura.Sub_total,
            Sub_total_iva: factura.Sub_total_iva,
            Valor_IVA: factura.Valor_IVA,
            Clientes_idClientes: factura.Clientes_idClientes
          });
          this.calculos();
        }
      });
    }
  }

  grabar() {
    let factura: IFactura = {
      idFactura: this.idFactura,
      Fecha: this.frm_factura.get('Fecha')?.value,
      Sub_total: this.frm_factura.get('Sub_total')?.value,
      Sub_total_iva: this.frm_factura.get('Sub_total_iva')?.value,
      Valor_IVA: this.frm_factura.get('Valor_IVA')?.value,
      Clientes_idClientes: this.frm_factura.get('Clientes_idClientes')?.value
    };

    if (this.idFactura) {
      this.facturaService.actualizar(factura).subscribe((respuesta) => {
        if (parseInt(respuesta) > 0) {
          alert('Factura actualizada');
          this.navegacion.navigate(['/facturas']);
        }
      });
    } else {
      this.facturaService.insertar(factura).subscribe((respuesta) => {
        if (parseInt(respuesta) > 0) {
          alert('Factura grabada');
          this.navegacion.navigate(['/facturas']);
        }
      });
    }
  }

  calculos() {
    let sub_total = this.frm_factura.get('Sub_total')?.value;
    let iva = this.frm_factura.get('Valor_IVA')?.value;
    let sub_total_iva = sub_total * iva;
    this.frm_factura.get('Sub_total_iva')?.setValue(sub_total_iva);
    this.totalapagar = parseInt(sub_total) + sub_total_iva;
  }

  cambio(objetoSelect: any) {
    let idCliente = objetoSelect.target.value;
    this.frm_factura.get('Clientes_idClientes')?.setValue(idCliente);
  }
}