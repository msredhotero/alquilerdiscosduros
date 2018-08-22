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
$fechaentrega	=	mysql_result($resVenta,0,'fechaentrega');


/*
if ($idsistema == 3) {
	$alto = $alto - ($residuoAlto / 1000);
}
*/
$hoja = array(62,25);

$anchoCorte = 0;
$pdf = new FPDF('L','mm',$hoja);
$pdf->SetMargins(0, 0 , 0); 
$pdf->SetAutoPageBreak(false);

while ($row = mysql_fetch_array($resOrden)) {

	$TotalIngresos = 0;
	$TotalEgresos = 0;
	$Totales = 0;
	$Caja = 0;
	$anchoCorte = 0;

	$anchoCorte = $row['ancho'] - ($row['residuoroller'] / 1000);

	

	// Carga de datos

	$pdf->AddPage();

	$pdf->SetFont('Arial','',6);

	$pdf->SetXY(1,1);
	$pdf->Cell(30,4,'Nro Venta: '.$nroVenta,0,0,'L',false);

	$pdf->SetXY(1,5);
	$pdf->Cell(30,4,'Nro Orden: '.$row['nroorden'],0,0,'L',false);

	$pdf->SetXY(35,1);
	$pdf->Cell(25,4,"Medida: ".$row['ancho'].' mtrs',0,0,'L',false);

	$pdf->SetXY(35,5);
	$pdf->Cell(25,4,"Corte: ".$anchoCorte.' mtrs',0,0,'L',false);

	$pdf->SetXY(1,10);
	$pdf->Cell(30,4,'Caño: '.$row['diametro'].' mm',0,0,'L',false);

	$pdf->SetXY(1,14);
	$pdf->Cell(60,4,'Cliente: '.$row['nombrecompleto'],0,0,'L',false);

	

	
}


$nombreTurno = "rptOrdenDeTrabajoTicketRoller-".date('Y-m-d')."-".$row['nroorden'].".pdf";

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

