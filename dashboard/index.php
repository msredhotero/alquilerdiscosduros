<?php

session_start();

if (!isset($_SESSION['usua_predio']))
{
	header('Location: ../error.php');
} else {


include ('../includes/funcionesUsuarios.php');
include ('../includes/funcionesHTML.php');
include ('../includes/funciones.php');
include ('../includes/funcionesReferencias.php');

$serviciosUsuario = new ServiciosUsuarios();
$serviciosHTML = new ServiciosHTML();
$serviciosFunciones = new Servicios();
$serviciosReferencias 	= new ServiciosReferencias();

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu($_SESSION['nombre_predio'],"Dashboard",$_SESSION['refroll_predio'],'');

/////////////////////// Opciones pagina ///////////////////////////////////////////////
$singular = "Reclamo";

$plural = "Reclamos";

$eliminar = "eliminarReclamos";

$insertar = "insertarReclamos";

$tituloWeb = "Gestión: Sistema de Reclamos";
//////////////////////// Fin opciones ////////////////////////////////////////////////



/////////////////////// Opciones para la creacion del view  apellido,nombre,nrodocumento,fechanacimiento,direccion,telefono,email/////////////////////
$cabeceras 		= "	<th>Asunto</th>
					<th>Usuario MercadoLibre</th>
					<th>Contraseña</th>
					<th>Mensaje</th>
					<th>Leido</th>
					<th>Estado</th>
					<th>Fecha</th>";

//////////////////////////////////////////////  FIN de los opciones //////////////////////////

$lstGridGeneral = $serviciosReferencias->traerGridPrincipal();

?>

<!DOCTYPE HTML>
<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">



<title>Gesti&oacute;n: Sistema de Alquiler de Discos Duros</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">


<link href="../css/estiloDash.css" rel="stylesheet" type="text/css">
    

    
    <script type="text/javascript" src="../js/jquery-1.8.3.min.js"></script>
    <link rel="stylesheet" href="../css/jquery-ui.css">

    <script src="../js/jquery-ui.js"></script>
    
	<!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css"/>
	<!--<link href='http://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext' rel='stylesheet' type='text/css'>-->
    <!-- Latest compiled and minified JavaScript -->
    <script src="../bootstrap/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="../css/chosen.css">


   
   <link href="../css/perfect-scrollbar.css" rel="stylesheet">
      <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>-->
      <script src="../js/jquery.mousewheel.js"></script>
      <script src="../js/perfect-scrollbar.js"></script>
      <script>
      jQuery(document).ready(function ($) {
        "use strict";
        $('#navigation').perfectScrollbar();
      });
    </script>

</head>

<body>

 
<?php echo str_replace('..','../dashboard',$resMenu); ?>

<div id="content">
	
    
<form class="form-inline formulario" role="form">
    
    <div class="row" style="margin-right:15px;margin-top:15px;">
    	<div class="col-md-12">
    		<div class="panel" style="border-color:#006666;">
				<div class="panel-heading" style="background-color:#006666; color:#FFF; ">
					<h3 class="panel-title">Alquileres</h3>
					<span class="pull-right clickable panel-collapsed" style="margin-top:-15px; cursor:pointer;"><i class="glyphicon glyphicon-chevron-up"></i></span>
				</div>
                    <div class="panel-body">
                    	<table class="table table-stripped table-responsive" id="example">
	  						<thead>
	  							<tr>
								  <td>Cine</td>
								  <td>Titulo</td>
								  <td>Disco</td>
								  <td>Fecha de Estreno</td>
								  <td>Fecha Devolución</td>
								  <td>Estado</td>
								  <td>Acciones</td>
								</tr>
							</thead>
							<tbody>

								<?php while ($row = mysql_fetch_array($lstGridGeneral)) {  ?>
								<tr>
									<td><?php echo $row['prestatario']; ?></td>
									<td><?php echo $row['titulo']; ?></td>
									<td><?php echo $row['numerohard']; ?></td>
									<td><?php echo $row['fechaestreno']; ?></td>
									<td><?php echo $row['fechadevolucion']; ?></td>
									<td><button type="button" class="btn" style="background-color: <?php echo $row['color']; ?>;"><?php echo $row['estado']; ?></button></td>
									<td>
										<button type="button" class="btn btn-primary vardevolver" id="<?php echo $row[0]; ?>" style="margin-left:0px;">Devolver</button>
										<button type="button" class="btn btn-warning varmodificar" id="<?php echo $row[0]; ?>" style="margin-left:0px;">Modificar</button>
										
									</td>
								</tr>

								<?php } ?>
							</tbody>
						</table>
                    </div>

                    		
				</div>
            </div>
    
    	</div>
    </div>
    
    
    
    
<div class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Registrar la Devolución</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  		<div class="row" id="formularioDinamico">
				
							
				<div class="form-group col-md-6" style="display:block">
					<label for="metodoentrega" class="control-label" style="text-align:left">Metodo de Entrega</label>
					<div class="input-group col-md-12">
						<select class="form-control" id="metodoentrega" name="metodoentrega">
							<option value='1'>Movil</option>
							<option value='2'>Transporte Tercero</option>		
						</select>
					</div>
				</div>
				
				
				
				<div class="form-group col-md-6 divMoviles" style="display:block">
					<label for="refmoviles" class="control-label" style="text-align:left">Moviles</label>
					<div class="input-group col-md-12">
						<select class="form-control" id="refmoviles" name="refmoviles">
						<?php echo $cadRef; ?>		
						</select>
					</div>
				</div>
				
				
				
				<div class="form-group col-md-6 divTransporte" style="display:block">
					<label for="reftransporteterceros" class="control-label" style="text-align:left">Transporte Terceros</label>
					<div class="input-group col-md-12">
						<select class="form-control" id="reftransporteterceros" name="reftransporteterceros">
						<?php echo $cadRef2; ?>		
						</select>
					</div>
				</div>
				
				
								
				<div class="form-group col-md-6 divNroguia" style="display:block">
					<label for="numeroguia" class="control-label" style="text-align:left">Nro Guia</label>
					<div class="input-group col-md-12">
						<input type="text" class="form-control" id="numeroguia" name="numeroguia" placeholder="Ingrese el Nro Guia..." required>
					</div>
				</div>
								
								
						
				<div class="form-group col-md-6" style="display:block">
					<label for="fechadevolucion" class="control-label" style="text-align:left">Fecha Devolución</label>
					<div class="input-group date form_date col-md-6 datefechadevolucion" data-date="" data-date-format="dd MM yyyy" data-link-field="fechadevolucion" data-link-format="yyyy-mm-dd">
						<input class="form-control" size="50" type="text" value="" readonly>
						<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
					</div>
					<input type="hidden" name="fechadevolucion" id="fechadevolucion" value="" />
				</div>


				<div class="form-group col-md-2" style="display:block">
					<label for="reftransporteterceros" class="control-label" style="text-align:left">Vuelve al Deposito</label>
					<div class="input-group col-md-12">
						<select class="form-control" id="aldeposito" name="aldeposito">
						<?php echo $cadSimple; ?>		
						</select>
					</div>
				</div>

				<div class="form-group col-md-12" style="display:block">
					<label for="reftransporteterceros" class="control-label" style="text-align:left">Observaciones</label>
					<div class="input-group col-md-12">
						<textarea id="observaciones" name="observaciones" class="form-control" col="50"></textarea>
					</div>
				</div>

			</div>
      </div>
      <div class="modal-footer">
		<input type="hidden" name="idalquiler" id="adalquiler" value="" />							
        <button type="button" class="btn btn-primary">Guardar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>   
    
    
   
</div>


</div>

</div>



<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
<script src="../bootstrap/js/dataTables.bootstrap.js"></script>

<script type="text/javascript">
$(document).ready(function(){
	
	$(document).on('click', '.panel-heading span.clickable', function(e){
		var $this = $(this);
		if(!$this.hasClass('panel-collapsed')) {
			$this.parents('.panel').find('.panel-body').slideUp();
			$this.addClass('panel-collapsed');
			$this.find('i').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
		} else {
			$this.parents('.panel').find('.panel-body').slideDown();
			$this.removeClass('panel-collapsed');
			$this.find('i').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
		}
	});


	
	$('#example').dataTable({
		"order": [[ 0, "asc" ]],
		"language": {
			"emptyTable":     "No hay datos cargados",
			"info":           "Mostrar _START_ hasta _END_ del total de _TOTAL_ filas",
			"infoEmpty":      "Mostrar 0 hasta 0 del total de 0 filas",
			"infoFiltered":   "(filtrados del total de _MAX_ filas)",
			"infoPostFix":    "",
			"thousands":      ",",
			"lengthMenu":     "Mostrar _MENU_ filas",
			"loadingRecords": "Cargando...",
			"processing":     "Procesando...",
			"search":         "Buscar:",
			"zeroRecords":    "No se encontraron resultados",
			"paginate": {
				"first":      "Primero",
				"last":       "Ultimo",
				"next":       "Siguiente",
				"previous":   "Anterior"
			},
			"aria": {
				"sortAscending":  ": activate to sort column ascending",
				"sortDescending": ": activate to sort column descending"
			}
		  }
	} );


	$("#example").on("click",'.vardevolver', function(){
		  usersid =  $(this).attr("id");
		  if (!isNaN(usersid)) {
			
			url = "reclamos/ver.php?id=" + usersid;
			$(location).attr('href',url);
		  } else {
			alert("Error, vuelva a realizar la acción.");	
		  }
	});//fin del boton modificar

	$("#example").on("click",'.varmodificar', function(){
		  usersid =  $(this).attr("id");
		  if (!isNaN(usersid)) {
			
			url = "reclamos/modificar.php?id=" + usersid;
			$(location).attr('href',url);
		  } else {
			alert("Error, vuelva a realizar la acción.");	
		  }
	});//fin del boton modificar


	


});
</script>

<?php } ?>
</body>
</html>
