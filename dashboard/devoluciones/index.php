<?php


session_start();

if (!isset($_SESSION['usua_predio']))
{
	header('Location: ../../error.php');
} else {


include ('../../includes/funciones.php');
include ('../../includes/funcionesUsuarios.php');
include ('../../includes/funcionesHTML.php');
include ('../../includes/funcionesReferencias.php');

$serviciosFunciones 	= new Servicios();
$serviciosUsuario 		= new ServiciosUsuarios();
$serviciosHTML 			= new ServiciosHTML();
$serviciosReferencias 	= new ServiciosReferencias();


//*** SEGURIDAD ****/
include ('../../includes/funcionesSeguridad.php');
$serviciosSeguridad = new ServiciosSeguridad();
$serviciosSeguridad->seguridadRuta($_SESSION['refroll_predio'], '../devoluciones/');
//*** FIN  ****/


$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu(utf8_encode($_SESSION['nombre_predio']),"Devoluciones",$_SESSION['refroll_predio'],'');


/////////////////////// Opciones pagina ///////////////////////////////////////////////
$singular = "Devolucion";

$plural = "Devoluciones";

$eliminar = "eliminarDevoluciones";

$insertar = "insertarDevoluciones";

$tituloWeb = "Gestión: Alquiler de Discos Duros";
//////////////////////// Fin opciones ////////////////////////////////////////////////


/////////////////////// Opciones para la creacion del formulario  /////////////////////
$tabla 			= "dbdevoluciones";

$lblCambio	 	= array("aldeposito","metodoentrega","refmoviles","reftransporteterceros","numeroguia","fechadevolucion","refprestatarios");
$lblreemplazo	= array("Fue devuelto al Deposito?","Metodo de Entrega","Moviles","Transporte Terceros","Nro Guia","Fecha Devolución","Prestatario");

$cadOpcional = '<option value="">-- Seleccionar --</option>';

$resVar1 = $serviciosReferencias->TraerMoviles();
$cadRef 	= $serviciosFunciones->devolverSelectBox($resVar1,array(1),'');

$resVar2 = $serviciosReferencias->TraerTransporteterceros();
$cadRef2 	= $serviciosFunciones->devolverSelectBox($resVar2,array(1),'');

$cadRef3 = "<option value='1'>Movil</option><option value='2'>Transporte Tercero</option>";

$resVar4 = $serviciosReferencias->TraerDiscosDeposito();
$cadRef4 	= $serviciosFunciones->devolverSelectBox($resVar4,array(1,2),' - ');

$refdescripcion = array(0=>$cadOpcional.$cadRef,1=>$cadOpcional.$cadRef2,2=>$cadRef3,3=>$cadRef4);
$refCampo 	=  array('refmoviles','reftransporteterceros','metodoentrega','refdiscos');
//////////////////////////////////////////////  FIN de los opciones //////////////////////////




/////////////////////// Opciones para la creacion del view  apellido,nombre,nrodocumento,fechanacimiento,direccion,telefono,email/////////////////////
$cabeceras 		= "	<th>Pelicula</th>
					<th>Disco</th>
					<th>Fecha Entrega</th>
					<th>Metodo de Ent.</th>
					<th>Movil</th>
					<th>Trans. 3ro</th>
					<th>Nro Guia</th>
					<th>Fecha Devolución</th>
					<th>Fecha Alta</th>";

//////////////////////////////////////////////  FIN de los opciones //////////////////////////




$formulario 	= $serviciosFunciones->camposTabla($insertar ,$tabla,$lblCambio,$lblreemplazo,$refdescripcion,$refCampo);

$lstCargados 	= $serviciosFunciones->camposTablaView($cabeceras,$serviciosReferencias->traerAlquileresGrid(),9);

$lstPrestatario = $serviciosFunciones->devolverSelectBox($serviciosReferencias->traerPrestatarios(),array(1,2),' - ');

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


<link href="../../css/estiloDash.css" rel="stylesheet" type="text/css">
    

    
    <script type="text/javascript" src="../../js/jquery-1.8.3.min.js"></script>
    <link rel="stylesheet" href="../../css/jquery-ui.css">

    <script src="../../js/jquery-ui.js"></script>
    
	<!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css"/>
	<link href='http://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <!-- Latest compiled and minified JavaScript -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="../../css/bootstrap-datetimepicker.min.css">
	
    <link rel="stylesheet" href="../../css/chosen.css">
   
   <link href="../../css/perfect-scrollbar.css" rel="stylesheet">
      <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>-->
      <script src="../../js/jquery.mousewheel.js"></script>
      <script src="../../js/perfect-scrollbar.js"></script>
      <script>
      jQuery(document).ready(function ($) {
        "use strict";
        $('#navigation').perfectScrollbar();
      });
    </script>
    
 
</head>

<body>

 <?php echo $resMenu; ?>

<div id="content">

<h3><?php echo $plural; ?></h3>

    <div class="boxInfoLargo">
        <div id="headBoxInfo">
        	<p style="color: #fff; font-size:18px; height:16px;">Carga de <?php echo $plural; ?></p>
        	
        </div>
    	<div class="cuerpoBox">
        	<form class="form-inline formulario" role="form">
        	<?php if (mysql_num_rows($resVar4) > 0) { ?>
			<div class="row">
	  			
				<div class="form-group col-md-6" style="display:block">
					<label for="refdiscos" class="control-label" style="text-align:left">Disco</label>
					<div class="input-group col-md-12">
						<select class="form-control" id="refdiscos" name="refdiscos">
							<?php echo $cadRef4; ?>		
						</select>
					</div>
				</div>


				<div class="form-group col-md-6" style="display:block">
					<label for="fechaentrega" class="control-label" style="text-align:left">Fecha Entrega</label>
					<div class="input-group date form_date col-md-6 datefechaentrega" data-date="" data-date-format="dd MM yyyy" data-link-field="fechaentrega" data-link-format="yyyy-mm-dd">
						<input class="form-control" size="50" type="text" value="" readonly>
						<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
					</div>
					<input type="hidden" name="fechaentrega" id="fechaentrega" value="" />
				</div>
						
						
				
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
						<?php echo $cadOpcional.$cadRef; ?>		
						</select>
					</div>
				</div>
				
				
				
				<div class="form-group col-md-6 divTransporte" style="display:block">
					<label for="reftransporteterceros" class="control-label" style="text-align:left">Transporte Terceros</label>
					<div class="input-group col-md-12">
						<select class="form-control" id="reftransporteterceros" name="reftransporteterceros">
						<?php echo $cadOpcional.$cadRef2; ?>		
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
				
				
				
				<div class="form-group col-md-6" style="display:none">
					<label for="fechacreacion" class="control-label" style="text-align:left">Fechacreacion</label>
					<div class="input-group bootstrap-timepicker col-md-6">
						<input id="timepicker2" name="fechacreacion" class="form-control">
						<span class="input-group-addon">
<span class="glyphicon glyphicon-time"></span>
</span>
					</div>
					
				</div>
						
						
				
				
				
				<br><br><input type="hidden" id="accion" name="accion" value="insertarAlquileres"/> 
            </div>


			<hr>
            
            <div class="row" id="contContacto" style="margin-left:0px; margin-right:25px;">
            	<div class="form-group col-md-6" style="display:'.$lblOculta.'">
                    <label for="buscarcontacto" class="control-label" style="text-align:left">Buscar Prestatarios</label>
                    <div class="input-group col-md-12">
                        
                        <select data-placeholder="selecione el Prestatario..." id="buscarcontacto" name="buscarcontacto" class="chosen-select" tabindex="2" style="width:300px;">
                            <option value=""></option>
                            <?php echo ($lstPrestatario); ?>
                        </select>
                        <button type="button" class="btn btn-success" id="asignarContacto"><span class="glyphicon glyphicon-share-alt"></span> Asignar Prestatario</button>
                    </div>
                </div>
                
                <div class="form-group col-md-6">
                    <label for="contactosasignados" class="control-label" style="text-align:left">Prestatario Asignados</label>
                    <div class="input-group col-md-12">
                        <ul class="list-inline" id="lstContact"></ul>
                        
                    </div>
                </div>
                
            </div>
            <!--
            <div class="row">
            	<div id="map" ></div>

            </div>
            -->
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
                        <button type="button" class="btn btn-primary" id="cargar" style="margin-left:0px;">Guardar</button>
                    </li>
                </ul>
                </div>
            </div>
			<?php } else { ?>
			<p>No existen discos en el deposito para alquilar.</p>

			<?php } ?>
            </form>
    	</div>
    </div>
    
    <div class="boxInfoLargo">
        <div id="headBoxInfo">
        	<p style="color: #fff; font-size:18px; height:16px;"><?php echo $plural; ?> Cargados</p>
        	
        </div>
    	<div class="cuerpoBox">
        	<?php echo $lstCargados; ?>
    	</div>
    </div>
    
    

    
    
   
</div>


</div>
<div id="dialog2" title="Eliminar <?php echo $singular; ?>">
    	<p>
        	<span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>
            ¿Esta seguro que desea eliminar el <?php echo $singular; ?>?.<span id="proveedorEli"></span>
        </p>
        <p><strong>Importante: </strong>Si elimina el <?php echo $singular; ?> se perderan todos los datos de este</p>
        <input type="hidden" value="" id="idEliminar" name="idEliminar">
</div>
<script type="text/javascript" src="../../js/jquery.dataTables.min.js"></script>
<script src="../../bootstrap/js/dataTables.bootstrap.js"></script>

<script src="../../js/bootstrap-datetimepicker.min.js"></script>
<script src="../../js/bootstrap-datetimepicker.es.js"></script>

<script type="text/javascript">
$(document).ready(function(){
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

	$('.divMoviles').show();
	$('.divTransporte').hide();
	$('.divNroguia').hide();


	$('#asignarContacto').click(function(e) {
		//alert($('#buscarcontacto option:selected').html());
		if (existeAsiganado('user'+$('#buscarcontacto').chosen().val()) == 0) {
			if ($('#buscarcontacto').chosen().val() != '') {
				$('#lstContact').prepend('<li class="user'+ $('#buscarcontacto').chosen().val() +'"><input id="user'+ $('#buscarcontacto').chosen().val() +'" class="form-control checkLstContactos" checked type="checkbox" required="" style="width:50px;" name="user'+ $('#buscarcontacto').chosen().val() +'"><p>' + $('#buscarcontacto option:selected').html() + ' </p></li>');
			}
		}
	});
	
	function existeAsiganado(id) {
		var existe = 0;	
		$('#lstContact li input').each(function (index, value) { 
		  if (id == $(this).attr('id')) {
			return existe = 1;  
		  }
		});
		
		return existe;
	}
	
	$("#lstContact").on("click",'.checkLstContactos', function(){
		usersid =  $(this).attr("id");
		
		if  (!($(this).prop('checked'))) {
			$('.'+usersid).remove();	
		}
	});

	$('#metodoentrega').change(function() {
		if ($(this).val() == '1') {
			$('.divMoviles').show();
			$('.divTransporte').hide();
			$('.divNroguia').hide();

		} else {
			$('.divMoviles').hide();
			$('.divTransporte').show();
			$('.divNroguia').show();
		}
	});
	

	$("#example").on("click",'.varborrar', function(){
		  usersid =  $(this).attr("id");
		  if (!isNaN(usersid)) {
			$("#idEliminar").val(usersid);
			$("#dialog2").dialog("open");

			
			//url = "../clienteseleccionado/index.php?idcliente=" + usersid;
			//$(location).attr('href',url);
		  } else {
			alert("Error, vuelva a realizar la acción.");	
		  }
	});//fin del boton eliminar
	
	$("#example").on("click",'.varmodificar', function(){
		  usersid =  $(this).attr("id");
		  if (!isNaN(usersid)) {
			
			url = "modificar.php?id=" + usersid;
			$(location).attr('href',url);
		  } else {
			alert("Error, vuelva a realizar la acción.");	
		  }
	});//fin del boton modificar


	function traerFechaEstrenoPorDisco(id) {
		$.ajax({
			data:  {iddisco: id, 
					accion: 'traerFechaEstrenoPorDisco'},
			url:   '../../ajax/ajax.php',
			type:  'post',
			beforeSend: function () {
					
			},
			success:  function (response) {
				$(".datefechadevolucion").datetimepicker("update", "'"+response+"'");
					
			}
		});
	}

	traerFechaEstrenoPorDisco($('#refdiscos').val());


	 $( "#dialog2" ).dialog({
		 	
			    autoOpen: false,
			 	resizable: false,
				width:600,
				height:240,
				modal: true,
				buttons: {
				    "Eliminar": function() {
	
						$.ajax({
							data:  {id: $('#idEliminar').val(), accion: '<?php echo $eliminar; ?>'},
							url:   '../../ajax/ajax.php',
							type:  'post',
							beforeSend: function () {
									
							},
							success:  function (response) {
									url = "index.php";
									$(location).attr('href',url);
									
							}
						});
						$( this ).dialog( "close" );
						$( this ).dialog( "close" );
							$('html, body').animate({
	           					scrollTop: '1000px'
	       					},
	       					1500);
				    },
				    Cancelar: function() {
						$( this ).dialog( "close" );
				    }
				}
		 
		 
	 		}); //fin del dialogo para eliminar
			
	<?php 
		echo $serviciosHTML->validacion($tabla);
	
	?>


	
	//al enviar el formulario
    $('#cargar').click(function(){
		if ($('#lstContact').is(':empty')) {
			alert('Debe cargar algun prestador!');
		} else {
			if (validador() == "")
			{
				//información del formulario
				var formData = new FormData($(".formulario")[0]);
				var message = "";
				//hacemos la petición ajax  
				$.ajax({
					url: '../../ajax/ajax.php',  
					type: 'POST',
					// Form data
					//datos del formulario
					data: formData,
					//necesario para subir archivos via ajax
					cache: false,
					contentType: false,
					processData: false,
					//mientras enviamos el archivo
					beforeSend: function(){
						$("#load").html('<img src="../../imagenes/load13.gif" width="50" height="50" />');       
					},
					//una vez finalizado correctamente
					success: function(data){

						if (data == '') {
												$(".alert").removeClass("alert-danger");
												$(".alert").removeClass("alert-info");
												$(".alert").addClass("alert-success");
												$(".alert").html('<strong>Ok!</strong> Se cargo exitosamente el <strong><?php echo $singular; ?></strong>. ');
												$(".alert").delay(3000).queue(function(){
													/*aca lo que quiero hacer 
													después de los 2 segundos de retraso*/
													$(this).dequeue(); //continúo con el siguiente ítem en la cola
													
												});
												$("#load").html('');
												url = "index.php";
												$(location).attr('href',url);
												
												
											} else {
												$(".alert").removeClass("alert-danger");
												$(".alert").addClass("alert-danger");
												$(".alert").html('<strong>Error!</strong> '+data);
												$("#load").html('');
											}
					},
					//si ha ocurrido un error
					error: function(){
						$(".alert").html('<strong>Error!</strong> Actualice la pagina');
						$("#load").html('');
					}
				});
			}
		}
    });

});
</script>

<script type="text/javascript">
$('.form_date').datetimepicker({
	language:  'es',
	weekStart: 1,
	todayBtn:  1,
	autoclose: 1,
	todayHighlight: 1,
	startView: 2,
	minView: 2,
	forceParse: 0,
	format: 'dd/mm/yyyy'
});
</script>

<script src="../../js/chosen.jquery.js" type="text/javascript"></script>
<script type="text/javascript">
    var config = {
      '.chosen-select'           : {},
      '.chosen-select-deselect'  : {allow_single_deselect:true},
      '.chosen-select-no-single' : {disable_search_threshold:10},
      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
      '.chosen-select-width'     : {width:"95%"}
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }
	
	
  </script>
<?php } ?>
</body>
</html>
