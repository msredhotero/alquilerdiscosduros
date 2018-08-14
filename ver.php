<?php


session_start();

if (!isset($_SESSION['usua_predio']))
{
	header('Location: error.php');
} else {


include ('includes/funciones.php');
include ('includes/funcionesUsuarios.php');
include ('includes/funcionesHTML.php');
include ('includes/funcionesReferencias.php');

$serviciosFunciones = new Servicios();
$serviciosUsuario 	= new ServiciosUsuarios();
$serviciosHTML 		= new ServiciosHTML();
$serviciosReferencias 	= new ServiciosReferencias();



$fecha = date('Y-m-d');


$id = $_GET['id'];
$password = $_GET['password'];

$resResultado = $serviciosReferencias->traerReclamosGridPorIdPassword($id, $password);

$archivos = $serviciosReferencias->TraerFotosNoticias($id);


/////////////////////// Opciones pagina ///////////////////////////////////////////////
$singular = "Reclamo";

$plural = "Reclamos";

$eliminar = "eliminarReclamos";

$modificar = "modificarReclamos";

$idTabla = "idreclamo";

$tituloWeb = "Gestión: Sistema de Reclamos";
//////////////////////// Fin opciones ////////////////////////////////////////////////


$resRespuesta = $serviciosReferencias->traerRespuestaRecursivaPorReclamo($id);


if ($_SESSION['refroll_predio'] != 1) {

} else {

	
}


?>

<!DOCTYPE HTML>
<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">



<title><?php echo $tituloWeb; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">


<link href="css/estilo.css" rel="stylesheet" type="text/css">
    

    
    <script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
    <link rel="stylesheet" href="css/jquery-ui.css">

    <script src="js/jquery-ui.js"></script>
    
	<!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css"/>
	<link href='http://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <!-- Latest compiled and minified JavaScript -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="css/bootstrap-datetimepicker.min.css">
	<style type="text/css">
		
  
		
	</style>
    
   
   <link href="css/perfect-scrollbar.css" rel="stylesheet">
      <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>-->
      <script src="js/jquery.mousewheel.js"></script>
      <script src="js/perfect-scrollbar.js"></script>
      <script>
      jQuery(document).ready(function ($) {
        "use strict";
        $('#navigation').perfectScrollbar();
      });
    </script>
</head>

<body>

<div id="content">
	<div class="row" >
    <div class="col-md-2" style="margin-left: 10px;">

    </div>
    <div class="col-md-8" style="background-color: #FFF; margin: 20px 15px; padding: 10px 10px; text-align: center;border-radius: 5px 5px 5px 5px;
-moz-border-radius: 5px 5px 5px 5px;
-webkit-border-radius: 5px 5px 5px 5px;
border: 0px solid #000000;box-shadow: 0 1px 3px 1px #80C48D;">
		
		<?php
			if (mysql_num_rows($resResultado)>0) {
		?>
		
		<p> <span class="navbar-right" style="font-size: 14px; color: #F39C12;"><span class="glyphicon glyphicon-calendar"></span> Fecha: <?php echo mysql_result($resResultado, 0,'fecha'); ?></span></p>
		<h3 style="color: #000;">Reclamo id: <?php echo $id; ?></h3>

	    <div class="boxInfoLargo">
	        <div id="headBoxInfo">
	        	
	        	
	        </div>
	    	<div class="cuerpoBox">
	        	<form class="form-inline formulario" role="form">
	        	
				<div class="row" style="padding-left: 15px;">
					<div class="form-group col-md-6 col-xs-6" style="text-align:left;display:block">
						<label for="asunto" class="control-label" style="text-align:left; font-size:1.4em;">Asunto</label>
						<div class="input-group col-md-12">
							<p>eqfwefw</p>
						</div>
					</div>

					<div class="form-group col-md-3 col-xs-3" style="text-align:left;display:block">
						<label for="leido" class="control-label" style="text-align:left; font-size:1.4em;"><b>Leido</b></label>
						<div class="input-group col-md-12">
							<p><?php echo mysql_result($resResultado, 0,'leido'); ?></p>
						</div>
					</div>

					<div class="form-group col-md-3 col-xs-3" style="text-align:left;display:block">
						<label for="refestados" class="control-label" style="text-align:left; font-size:1.4em;"><b>Estado</b></label>
						<div class="input-group col-md-12">
							<p>
								<option value="1"><?php echo mysql_result($resResultado, 0,'estado'); ?></option>		</p>
						</div>
					</div>
				
					<div class="form-group col-md-12 col-xs-12" style="text-align:left;display:block">
						<label for="mensaje" class="control-label" style="text-align:left; font-size:1.4em;"><b>Mensaje</b></label>
						<div class="input-group col-md-12">
							<p><?php echo mysql_result($resResultado, 0,'mensaje'); ?></p>
						</div>
						
					</div>

					<div class="form-group col-md-12 col-xs-12" style="text-align:left;display:block">
						<label for="mensaje" class="control-label" style="text-align:left; font-size:1.4em;"><b>Respuestas</b></label>
						<div class="input-group col-md-12">
							<hr>
							<div class="lstMensajes">
			            	<?php
			            		$padding = 0;
								while ($row = mysql_fetch_array($resRespuesta)) {


							?>
							<p style="padding-left: <?php echo $padding; ?>px;"><span class="
			glyphicon glyphicon-comment"></span> <?php echo ($row['quien'] == 'Administrado' ? 'Administrado' : 'Usted'); ?>: <?php echo $row['mensaje']; ?></p>
							<?php
								$padding += 10;
								}
							?>
							</div>
							<hr>
							<textarea type="text" rows="10" cols="6" class="form-control" id="pregunta" name="pregunta" placeholder="Ingrese la pregunta..." required></textarea>
							<button type="button" class="btn btn-default preguntar" style="margin-left:0px;"><span class="glyphicon glyphicon-send"></span> Enviar</button>
						</div>
						
					</div>
								
					
						

					


					<div class="row">
					<ul class="list-inline">
						<?php 
							while ($row = mysql_fetch_array($archivos)) {
						?>
						<li><a href="<?php echo 'archivos/'.$row['archivo']; ?>" target='_blanck'>Ver Archivo</a></li>
						<?php
						}
						?>
					</ul>
					</div>
	            </div>
	            
	            
	            <div class='row' style="margin-left:25px; margin-right:25px;">
	                <div class='alert'>
	                
	                </div>
	                <div id='load'>
	                
	                </div>
	            </div>
	            
	            <div class="row">
	                <div class="col-md-12">
	                <ul class="list-inline" style="margin-top:15px;">
	                    <li>
	                        <button type="button" class="btn btn-default volver" style="margin-left:0px;">Volver</button>
	                    </li>
	                </ul>
	                </div>
	            </div>
	            </form>
	    	</div>
	    </div>
		<?php } else { ?>
		<h3 style="color: #000;">Reclamo no encontrado</h3>
	    <div class="boxInfoLargo">
	        <div id="headBoxInfo">
	        	
	        	
	        </div>
	    	<div class="cuerpoBox">
	        	<form class="form-inline formulario" role="form">
	        	
				<div class="row">
					<p>ID de reclamo erroneo o Contraseña incorrecta</p>
	            </div>

	            
	            <div class="row">
	                <div class="col-md-12">
	                <ul class="list-inline" style="margin-top:15px;">
	                    <li>
	                        <button type="button" class="btn btn-default volver" style="margin-left:0px;">Volver</button>
	                    </li>
	                </ul>
	                </div>
	            </div>
	            </form>
	    	</div>
	    </div>
		<?php } ?>			
     </div>
    <div class="col-md-2"></div>
    
   
</div>


</div>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Mensajes</h4>
      </div>
      <div class="modal-body">
        <p id="resultado"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<script src="bootstrap/js/dataTables.bootstrap.js"></script>

<script src="js/bootstrap-datetimepicker.min.js"></script>
<script src="js/bootstrap-datetimepicker.es.js"></script>

<script type="text/javascript">
$(document).ready(function(){

	$('.volver').click(function(event){
		 
		url = "index.php";
		$(location).attr('href',url);
	});//fin del boton modificar

	$('.preguntar').click(function() {
		$.ajax({
			data:  {id: <?php echo $id; ?>, 
					pregunta: $('#pregunta').val(),
					accion: 'insertarPregunta'},
			url:   'ajax/ajax.php',
			type:  'post',
			beforeSend: function () {
				$('#resultado').html('');	
			},
			success:  function (response) {
				$('#resultado').html('Se pregunta fue envia exitosamente!!.');
				$('.lstMensajes').append('<p style="padding-left: <?php echo ($padding + 10); ?>px;"><span class="glyphicon glyphicon-comment"></span> Usted: ' + $('#pregunta').val() + '</p>');
				$('#myModal').modal();
					
			}
		});
	})
	
	

});
</script>


<?php } ?>
</body>
</html>
