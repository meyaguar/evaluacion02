<?php

/**************************************** 
 *  REPORTE PARA LA IMPRESIÓN DEL INVENTARIO
 *  By: YAGUAR, Eduardo
 *  Date: 19/09/2024 
 ****************************************/

require('fpdf/fpdf.php');
require_once("../models/productos.model.php");

class PDF extends FPDF {

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', '', 8);
        $this->Cell(0, 10, iconv('UTF-8', 'ISO-8859-1', 'Página ' . $this->PageNo() . '/{nb}'), 0, 0, 'C');
    }
}

$pdf = new PDF('P', 'mm', 'A4');

// Obtener los productos desde el controlador
$productos = new Productos();
$data_productos = $productos->todos();

// Agregar página
$pdf->AddPage();

// TODO: Incrustar la cabecera del reporte en el HEADER de la página, 
//       para que se imprima en todas las páginas si el reporte es muy grande

// Configurar la cabecera
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 15);
$pdf->Cell(190, 10, iconv('UTF-8', 'ISO-8859-1', 'REPORTE DE INVENTARIO'), 0, 1, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(190, 10, iconv('UTF-8', 'ISO-8859-1', 'Fecha: ' . date('d-m-Y')), 0, 1, 'C');

// Espacio entre cabecera y tabla
$pdf->Ln(10);

// Configurar la tabla
$pdf->SetFont('Arial', 'B', 10);

// Títulos de la tabla
$pdf->SetFillColor(0, 0, 0); // Fondo negro
$pdf->SetTextColor(255, 255, 255); // Texto blanco
$pdf->Cell(20, 8, iconv('UTF-8', 'ISO-8859-1', 'Código'), 1, 0, 'C', true);
$pdf->Cell(60, 8, iconv('UTF-8', 'ISO-8859-1', 'Nombre'), 1, 0, 'C', true);
$pdf->Cell(60, 8, iconv('UTF-8', 'ISO-8859-1', 'Descripción'), 1, 0, 'C', true);
$pdf->Cell(20, 8, iconv('UTF-8', 'ISO-8859-1', 'Precio'), 1, 0, 'C', true);
$pdf->Cell(20, 8, iconv('UTF-8', 'ISO-8859-1', 'Stock'), 1, 0, 'C', true);
$pdf->Ln();

// Restablecer colores
$pdf->SetFillColor(230); // Fondo claro
$pdf->SetTextColor(0, 0, 0); // Texto negro
$pdf->SetFont('Arial', '', 10);

// Configurar el pie de página
$pdf->AliasNbPages('{nb}');
$pdf->SetAutoPageBreak(true, 15); // Establece el margen inferior en 15 mm

// Contenido de la tabla
$fill = false;
foreach ($data_productos as $producto) {
    $pdf->SetFillColor($fill ? 230 : 255);
    $pdf->Cell(20, 8, $producto['producto_id'], 1, 0, 'L', $fill);
    $pdf->Cell(60, 8, iconv('UTF-8', 'ISO-8859-1', $producto['nombre']), 1, 0, 'L', $fill);
    $pdf->Cell(60, 8, iconv('UTF-8', 'ISO-8859-1', $producto['descripcion']), 1, 0, 'L', $fill);
    $pdf->Cell(20, 8, $producto['precio'], 1, 0, 'R', $fill);
    $pdf->Cell(20, 8, $producto['stock'], 1, 0, 'R', $fill);
    $pdf->Ln();
    $fill = !$fill;
}

// Salida del PDF
$pdf->Output('reporte_inventario.pdf', 'I');

?>