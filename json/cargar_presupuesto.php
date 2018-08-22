<?php

include ('../includes/funcionesUsuarios.php');
include ('../includes/funciones.php');
include ('../includes/funcionesHTML.php');
include ('../includes/funcionesReferencias.php');


$serviciosUsuarios  		= new ServiciosUsuarios();
$serviciosFunciones 		= new Servicios();
$serviciosHTML				= new ServiciosHTML();
$serviciosReferencias		= new ServiciosReferencias();


//Recibimos el Array y lo decodificamos desde json, para poder utilizarlo como objeto


//$DATA     = json_decode($_POST['data']);
$json = $_POST['data'];
//'[{"id":"1","sistema":"1","tela":"1","residuo":"1","telaopcional":"0","alto":"2","ancho":"1","totalparcial":"880","usuacrea":"Saupurein Marcos","refusuarios":1}]';

$json = json_decode($json);

//die(var_dump(count($json)));

$refCabeceraPresupuesto = $serviciosReferencias->insertarCabecerapresupuesto($json[0]->refusuarios, $json[0]->refclientes, date('Y-m-d'), $json[0]->total,0,$json[0]->solicitante,$json[0]->nrodocumento,$json[0]->observaciones, 1,$json[0]->fechaentrega);

$monto = 0;
for ($i=0; $i < count($json); $i++) {


	$resSistemas = $serviciosReferencias->traerSistemasPorSistema($json[$i]->sistema);
	$resTelas	 = $serviciosReferencias->traerTelasPorId($json[$i]->tela);

	if ($json[$i]->sistema == 1) {
		$serviciosReferencias->insertarPresupuestos(date('Y-m-d'),'',$json[$i]->usuacrea,'',1,$json[$i]->sistema,$json[$i]->tela,$json[$i]->residuo,mysql_result($resSistemas,0,'roller'),mysql_result($resTelas,0,'tipotramado'),$json[$i]->ancho,$json[$i]->alto,$json[$i]->telaopcional,0,$json[$i]->totalparcial,$refCabeceraPresupuesto,$json[$i]->cantidad,$json[$i]->caida,$json[$i]->mando);
	} else {
		$resTelasOpcional	 = $serviciosReferencias->traerTelasPorId($json[$i]->telaopcional);
		$serviciosReferencias->insertarPresupuestos(date('Y-m-d'),'',$json[$i]->usuacrea,'',1,$json[$i]->sistema,$json[$i]->tela,$json[$i]->residuo,mysql_result($resSistemas,0,'roller'),mysql_result($resTelas,0,'tipotramado').' - Segunda Tela: '.mysql_result($resTelasOpcional,0,'tipotramado'),$json[$i]->ancho,$json[$i]->alto,$json[$i]->telaopcional,1,$json[$i]->totalparcial ,$refCabeceraPresupuesto,$json[$i]->cantidad,$json[$i]->caida,$json[$i]->mando);
	}
	

}
echo 'Presupuesto generado correctamente!!.';

?>