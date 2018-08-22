<?php

date_default_timezone_set('America/Buenos_Aires');

include ('../includes/funcionesUsuarios.php');
include ('../includes/funciones.php');
include ('../includes/funcionesHTML.php');
include ('../includes/funcionesReferencias.php');


$serviciosUsuarios  		= new ServiciosUsuarios();
$serviciosFunciones 		= new Servicios();
$serviciosHTML				= new ServiciosHTML();
$serviciosReferencias 		= new ServiciosReferencias();
//$serviciosReportes			= new ServiciosReportes();

$fecha = date('Y-m-d');

require('fpdf.php');

//$header = array("Hora", "Cancha 1", "Cancha 2", "Cancha 3");

$id				=	$_GET['id'];

$resOrden		=	$serviciosReferencias->traerOrdenesPorVenta($id);

$resVenta		=	$serviciosReferencias->traerVentasPorId($id);

$nroVenta		=	mysql_result($resVenta,0,'numero');
$cliente		=	mysql_result($resVenta,0,'nombrecompleto');
$fecha			=	mysql_result($resVenta,0,'fecha');
$cantidadtotal	=	mysql_result($resVenta,0,'cantidadtotal');
$total			=	mysql_result($resVenta,0,'total');


/*
if ($idsistema == 3) {
	$alto = $alto - ($residuoAlto / 1000);
}
*/
$TotalIngresos = 0;
$TotalEgresos = 0;
$Totales = 0;
$Caja = 0;



$pdf = new FPDF();



// Carga de datos

$pdf->AddPage();

$pdf->SetFont('Arial','',10);

$pdf->SetXY(5,3);
$pdf->Cell(32,5,'Nro Venta',1,0,'C',false);

$pdf->SetXY(37,3);
$pdf->Cell(95,5,"Cliente",1,0,'C',false);

$pdf->SetXY(132,3);
$pdf->Cell(25,5,"Fecha",1,0,'C',false);

$pdf->SetXY(157,3);
$pdf->Cell(25,5,"Cantidad",1,0,'C',false);

$pdf->SetXY(182,3);
$pdf->Cell(25,5,"Monto",1,0,'C',false);


$pdf->SetXY(5,8);
$pdf->Cell(32,5,strtoupper($nroVenta),1,0,'C',false);

$pdf->SetXY(37,8);
$pdf->Cell(95,5,$cliente,1,0,'L',false);

$pdf->SetXY(132,8);
$pdf->Cell(25,5,$fecha,1,0,'C',false);

$pdf->SetXY(157,8);
$pdf->Cell(25,5,$cantidadtotal,1,0,'R',false);

$pdf->SetXY(182,8);
$pdf->Cell(25,5,'$ '.$total,1,0,'R',false);

/************* orden  *************************/
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Cell(190,5,'Orden de Trabajos: Corte de Caños',1,0,'C',false);
$pdf->Ln();
$pdf->Ln();

$pdf->SetFont('Arial','',8);

$pdf->Cell(22,5,'Orden',1,0,'C',false);
$pdf->Cell(40,5,'Sistema',1,0,'C',false);
$pdf->Cell(15,5,'Cant',1,0,'C',false);
$pdf->Cell(15,5,'Caño',1,0,'C',false);
$pdf->Cell(20,5,'Ancho Real',1,0,'C',false);
$pdf->Cell(20,5,'Ancho Corte',1,0,'C',false);
$pdf->Cell(20,5,'Zocalo Corte',1,0,'C',false);
$pdf->Cell(20,5,'Finalizado',1,0,'C',false);

$pdf->Ln();
$anchoCorte = 0;
$anchoZocaloCorte = 0;

while ($row = mysql_fetch_array($resOrden)) {
	$anchoCorte = $row['ancho'] - ($row['residuoroller'] / 1000);
	$anchoZocaloCorte = $row['ancho'] - ($row['residuozocalo'] / 1000);

	$pdf->Cell(22,5,$row['nroorden'],1,0,'C',false);
	$pdf->Cell(40,5,$row['sistema'],1,0,'L',false);
	$pdf->Cell(15,5,$row['cantidad'],1,0,'C',false);
	$pdf->Cell(15,5,$row['roller'],1,0,'C',false);
	$pdf->Cell(20,5,$row['ancho'],1,0,'C',false);
	$pdf->Cell(20,5,$anchoCorte,1,0,'C',false);
	$pdf->Cell(20,5,$anchoZocaloCorte,1,0,'C',false);
	$pdf->Cell(20,5,'',1,0,'C',false);
	$pdf->Ln();
}


$pdf->SetFont('Arial','',13);

$nombreTurno = "rptOrdenDeTrabajoRoller-".date('Y-m-d').".pdf";

$pdf->Output($nombreTurno,'I');

/*
require('fpdf.php');

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(40,10,'¡Hola, Mundo!');
$pdf->Output();
*/
?>

