<?php

include ('../includes/funcionesUsuarios.php');
include ('../includes/funciones.php');
include ('../includes/funcionesHTML.php');
include ('../includes/funcionesReferencias.php');


$serviciosUsuarios  		= new ServiciosUsuarios();
$serviciosFunciones 		= new Servicios();
$serviciosHTML				= new ServiciosHTML();
$serviciosReferencias		= new ServiciosReferencias();


$accion = $_POST['accion'];


switch ($accion) {
    case 'login':
        enviarMail($serviciosUsuarios);
        break;
	case 'entrar':
		entrar($serviciosUsuarios);
		break;
	case 'insertarUsuario':
        insertarUsuario($serviciosUsuarios);
        break;
	case 'modificarUsuario':
        modificarUsuario($serviciosUsuarios);
        break;
	case 'registrar':
		registrar($serviciosUsuarios);
        break;
	case 'existe':
		existe($serviciosReferencias);
        break;


		case 'insertarAlquileres': 
		insertarAlquileres($serviciosReferencias); 
		break; 
		case 'modificarAlquileres': 
		modificarAlquileres($serviciosReferencias); 
		break; 
		case 'eliminarAlquileres': 
		eliminarAlquileres($serviciosReferencias); 
		break; 
		case 'insertarAlquileresprestatarios': 
		insertarAlquileresprestatarios($serviciosReferencias); 
		break; 
		case 'modificarAlquileresprestatarios': 
		modificarAlquileresprestatarios($serviciosReferencias); 
		break; 
		case 'eliminarAlquileresprestatarios': 
		eliminarAlquileresprestatarios($serviciosReferencias); 
		break; 
		case 'insertarClientes': 
		insertarClientes($serviciosReferencias); 
		break; 
		case 'modificarClientes': 
		modificarClientes($serviciosReferencias); 
		break; 
		case 'eliminarClientes': 
		eliminarClientes($serviciosReferencias); 
		break; 
		case 'insertarDevoluciones': 
		insertarDevoluciones($serviciosReferencias); 
		break; 
		case 'modificarDevoluciones': 
		modificarDevoluciones($serviciosReferencias); 
		break; 
		case 'eliminarDevoluciones': 
		eliminarDevoluciones($serviciosReferencias); 
		break; 
		case 'insertarDiscos': 
		insertarDiscos($serviciosReferencias); 
		break; 
		case 'modificarDiscos': 
		modificarDiscos($serviciosReferencias); 
		break; 
		case 'eliminarDiscos': 
		eliminarDiscos($serviciosReferencias); 
		break; 

		case 'traerFechaEstrenoPorDisco':
			traerFechaEstrenoPorDisco($serviciosReferencias);
		break;
		case 'existeDiscosPorNro':
			existeDiscosPorNro($serviciosReferencias);
			break;

		case 'insertarPeliculas': 
		insertarPeliculas($serviciosReferencias); 
		break; 
		case 'modificarPeliculas': 
		modificarPeliculas($serviciosReferencias); 
		break; 
		case 'eliminarPeliculas': 
		eliminarPeliculas($serviciosReferencias); 
		break; 
		case 'insertarPrestatarios': 
		insertarPrestatarios($serviciosReferencias); 
		break; 
		case 'modificarPrestatarios': 
		modificarPrestatarios($serviciosReferencias); 
		break; 
		case 'eliminarPrestatarios': 
		eliminarPrestatarios($serviciosReferencias); 
		break; 
		case 'insertarUsuarios': 
		insertarUsuarios($serviciosReferencias); 
		break; 
		case 'modificarUsuarios': 
		modificarUsuarios($serviciosReferencias); 
		break; 
		case 'eliminarUsuarios': 
		eliminarUsuarios($serviciosReferencias); 
		break; 
		case 'insertarPredio_menu': 
		insertarPredio_menu($serviciosReferencias); 
		break; 
		case 'modificarPredio_menu': 
		modificarPredio_menu($serviciosReferencias); 
		break; 
		case 'eliminarPredio_menu': 
		eliminarPredio_menu($serviciosReferencias); 
		break; 
		case 'insertarEstados': 
		insertarEstados($serviciosReferencias); 
		break; 
		case 'modificarEstados': 
		modificarEstados($serviciosReferencias); 
		break; 
		case 'eliminarEstados': 
		eliminarEstados($serviciosReferencias); 
		break; 
		case 'insertarMoviles': 
		insertarMoviles($serviciosReferencias); 
		break; 
		case 'modificarMoviles': 
		modificarMoviles($serviciosReferencias); 
		break; 
		case 'eliminarMoviles': 
		eliminarMoviles($serviciosReferencias); 
		break; 
		case 'insertarRoles': 
		insertarRoles($serviciosReferencias); 
		break; 
		case 'modificarRoles': 
		modificarRoles($serviciosReferencias); 
		break; 
		case 'eliminarRoles': 
		eliminarRoles($serviciosReferencias); 
		break; 
		case 'insertarTransporteterceros': 
		insertarTransporteterceros($serviciosReferencias); 
		break; 
		case 'modificarTransporteterceros': 
		modificarTransporteterceros($serviciosReferencias); 
		break; 
		case 'eliminarTransporteterceros': 
		eliminarTransporteterceros($serviciosReferencias); 
		break; 

		case 'buscaralquileres':
		buscaralquileres($serviciosReferencias);
		break;

}





/* Fin */

function buscaralquileres($serviciosReferencias) {
	$id = $_POST['idprestatario'];

	$res = $serviciosReferencias->traerAlquileresprestatariosPorPrestatario($id);

	$cad = '<ul class="list-inline lstDiscos">';

	while ($row = mysql_fetch_array($res)) {
		$cad .= '<li class="user'.$row[0].'">
		<p><input id="user'.$row[0].'" class="form-control checkLstContactos" type="checkbox" required="" style="width:50px;" name="user'.$row[0].'">
		Pelicula: '.$row[1].' - Nro Hard: '.$row[2].' </p>
		</li>';
	}

	$cad .= '</ul>';

	echo $cad;
}

function traerFechaEstrenoPorDisco($serviciosReferencias) {
	$id = $_POST['iddisco'];
	$fechaentrega = $_POST['fechaentrega'];

	$res = $serviciosReferencias->traerFechaEstrenoPorDisco($id,$fechaentrega);

	echo $res;
}

function existeDiscosPorNro($serviciosReferencias) {
	$numerohard = $_POST['numerohard'];

	$res = $serviciosReferencias->traerDiscosPorNro($numerohard);

	if (mysql_num_rows($res)>0) {
		echo 'Si';
	} else {
		echo 'No';
	}
}

function insertarAlquileres($serviciosReferencias) { 
	$fechaentrega = $_POST['fechaentrega']; 
	$metodoentrega = $_POST['metodoentrega']; 
	$refmoviles = $_POST['refmoviles']; 
	$reftransporteterceros = $_POST['reftransporteterceros']; 
	$numeroguia = $_POST['numeroguia']; 
	$fechadevolucion = $_POST['fechadevolucion']; 
	$refdiscos = $_POST['refdiscos']; 

	if ($metodoentrega == 1) {
		$reftransporteterceros = 0;
		$numeroguia = '';
	} else {
		$refmoviles = 0;
	}
	
	
	$res = $serviciosReferencias->insertarAlquileres($fechaentrega,$metodoentrega,$refmoviles,$reftransporteterceros,$numeroguia,$fechadevolucion,$refdiscos); 
	
	if ((integer)$res > 0) { 

		$resUser = $serviciosReferencias->traerPrestatarios();
		$cad = 'user';
		while ($rowFS = mysql_fetch_array($resUser)) {
			if (isset($_POST[$cad.$rowFS[0]])) {
				$serviciosReferencias->insertarAlquileresprestatarios($res,$rowFS[0]);
			}
		}
		if ($metodoentrega == 1) {
			$serviciosReferencias->modificarEstadoDiscos($refdiscos,2);
		} else {
			$serviciosReferencias->modificarEstadoDiscos($refdiscos,3);
		}
		
		echo ''; 
	} else { 
		echo 'Hubo un error al insertar datos ';	 
	} 
} 
	
	function modificarAlquileres($serviciosReferencias) { 
		$id = $_POST['id']; 
		$fechaentrega = $_POST['fechaentrega']; 
		$metodoentrega = $_POST['metodoentrega']; 
		$refmoviles = $_POST['refmoviles']; 
		$reftransporteterceros = $_POST['reftransporteterceros']; 
		$numeroguia = $_POST['numeroguia']; 
		$fechadevolucion = $_POST['fechadevolucion']; 
		$refdiscos = $_POST['refdiscos']; 

		if ($metodoentrega == 1) {
			$reftransporteterceros = 0;
			$numeroguia = '';
		} else {
			$refmoviles = 0;
		}
		
		
		$res = $serviciosReferencias->modificarAlquileres($id,$fechaentrega,$metodoentrega,$refmoviles,$reftransporteterceros,$numeroguia,$fechadevolucion,$refdiscos); 
		
		if ($res == true) { 
			$serviciosReferencias->eliminarAlquileresprestatariosPorAlquiler($id);
			$resUser = $serviciosReferencias->traerPrestatarios();
			$cad = 'user';
			while ($rowFS = mysql_fetch_array($resUser)) {
				if (isset($_POST[$cad.$rowFS[0]])) {
					$serviciosReferencias->insertarAlquileresprestatarios($id,$rowFS[0]);
				}
			}
			echo ''; 
		} else { 
			echo 'Hubo un error al modificar datos'; 
		} 
	} 
	
	function eliminarAlquileres($serviciosReferencias) { 
	$id = $_POST['id']; 
	
	$res = $serviciosReferencias->eliminarAlquileres($id); 
	
	echo $res; 
	} 
	
	function insertarAlquileresprestatarios($serviciosReferencias) { 
	$refalquileres = $_POST['refalquileres']; 
	$refprestatarios = $_POST['refprestatarios']; 
	
	
	$res = $serviciosReferencias->insertarAlquileresprestatarios($refalquileres,$refprestatarios); 
	
	if ((integer)$res > 0) { 
	echo ''; 
	} else { 
	echo 'Hubo un error al insertar datos';	 
	} 
	} 
	
	function modificarAlquileresprestatarios($serviciosReferencias) { 
	$id = $_POST['id']; 
	$refalquileres = $_POST['refalquileres']; 
	$refprestatarios = $_POST['refprestatarios']; 
	
	
	$res = $serviciosReferencias->modificarAlquileresprestatarios($id,$refalquileres,$refprestatarios); 
	
	if ($res == true) { 
	echo ''; 
	} else { 
	echo 'Hubo un error al modificar datos'; 
	} 
	} 
	
	function eliminarAlquileresprestatarios($serviciosReferencias) { 
	$id = $_POST['id']; 
	
	$res = $serviciosReferencias->eliminarAlquileresprestatarios($id); 
	
	echo $res; 
	} 
	
	function insertarClientes($serviciosReferencias) { 
	$razonsocial = $_POST['razonsocial']; 
	$cuit = $_POST['cuit']; 
	$telefono = $_POST['telefono']; 
	$email = $_POST['email']; 
	$direccion = $_POST['direccion']; 
	$provincia = $_POST['provincia']; 
	$ciudad = $_POST['ciudad']; 
	
	
	$res = $serviciosReferencias->insertarClientes($razonsocial,$cuit,$telefono,$email,$direccion,$provincia,$ciudad); 
	
	if ((integer)$res > 0) { 
	echo ''; 
	} else { 
	echo 'Hubo un error al insertar datos';	 
	} 
	} 
	
	function modificarClientes($serviciosReferencias) { 
	$id = $_POST['id']; 
	$razonsocial = $_POST['razonsocial']; 
	$cuit = $_POST['cuit']; 
	$telefono = $_POST['telefono']; 
	$email = $_POST['email']; 
	$direccion = $_POST['direccion']; 
	$provincia = $_POST['provincia']; 
	$ciudad = $_POST['ciudad']; 
	
	
	$res = $serviciosReferencias->modificarClientes($id,$razonsocial,$cuit,$telefono,$email,$direccion,$provincia,$ciudad); 
	
	if ($res == true) { 
	echo ''; 
	} else { 
	echo 'Hubo un error al modificar datos'; 
	} 
	} 
	
	function eliminarClientes($serviciosReferencias) { 
	$id = $_POST['id']; 
	
	$res = $serviciosReferencias->eliminarClientes($id); 
	
	echo $res; 
	} 
	
	function insertarDevoluciones($serviciosReferencias) { 
		$refprestatarios = $_POST['refprestatarios']; 
		$metodoentrega = $_POST['metodoentrega']; 
		$refmoviles = $_POST['refmoviles']; 
		$reftransporteterceros = $_POST['reftransporteterceros']; 
		$numeroguia = $_POST['numeroguia']; 
		$fechadevolucion = $_POST['fechadevolucion']; 
		if (isset($_POST['aldeposito'])) { 
			$aldeposito	= 1; 
		} else { 
			$aldeposito = 0; 
		} 
		$observaciones = $_POST['observaciones']; 
		
		
		$resUser = $serviciosReferencias->traerAlquileresprestatariosPorPrestatario($refprestatarios);
		$cad = 'user';
		while ($rowFS = mysql_fetch_array($resUser)) {
			if (isset($_POST[$cad.$rowFS[0]])) {

				$res = $serviciosReferencias->insertarDevoluciones($refprestatarios,$metodoentrega,$refmoviles,$reftransporteterceros,$numeroguia,$fechadevolucion,$aldeposito,$observaciones,$rowFS[5]); 

				if ($aldeposito == 1) {
					$serviciosReferencias->modificarEstadoDiscos($rowFS[5],1);
				} else {
					$serviciosReferencias->modificarEstadoDiscos($rowFS[5],5);
				}
			}
		}
		

		
		
		if ((integer)$res > 0) { 
			echo ''; 
		} else { 
			echo 'Hubo un error al insertar datos';	 
		} 
	} 
	
	function modificarDevoluciones($serviciosReferencias) { 
		$id = $_POST['id']; 
		$refprestatarios = $_POST['refprestatarios']; 
		$metodoentrega = $_POST['metodoentrega']; 
		$refmoviles = $_POST['refmoviles']; 
		$reftransporteterceros = $_POST['reftransporteterceros']; 
		$numeroguia = $_POST['numeroguia']; 
		$fechadevolucion = $_POST['fechadevolucion']; 
		
		if (isset($_POST['aldeposito'])) { 
			$aldeposito	= 1; 
		} else { 
			$aldeposito = 0; 
		} 
		$observaciones = $_POST['observaciones']; 
		
		
		$res = $serviciosReferencias->modificarDevoluciones($id,$refprestatarios,$metodoentrega,$refmoviles,$reftransporteterceros,$numeroguia,$fechadevolucion,$aldeposito,$observaciones); 
		
		if ($res == true) { 
			echo ''; 
		} else { 
			echo 'Hubo un error al modificar datos'; 
		} 
	} 
	
	function eliminarDevoluciones($serviciosReferencias) { 
	$id = $_POST['id']; 
	
	$res = $serviciosReferencias->eliminarDevoluciones($id); 
	
	echo $res; 
	} 
	
	function insertarDiscos($serviciosReferencias) { 
		$cantidad = $_POST['cantidad']; 
		$refpeliculas = $_POST['refpeliculas']; 
		$refestados = $_POST['refestados']; 


		$nroHardComienzo = $serviciosReferencias->traerUltimoNroHardPorPelicula($refpeliculas);
	
		for ($i=1;$i<=$cantidad;$i++) {
			$res = $serviciosReferencias->insertarDiscos($i + $nroHardComienzo,$refpeliculas,$refestados); 
		}
		
	
		if ((integer)$res > 0) { 
			echo ''; 
		} else { 
			echo 'Hubo un error al insertar datos';	 
		} 
	} 
	
	function modificarDiscos($serviciosReferencias) { 
	$id = $_POST['id']; 
	$numerohard = $_POST['numerohard']; 
	$refpeliculas = $_POST['refpeliculas']; 
	$refestados = $_POST['refestados']; 
	
	
	$res = $serviciosReferencias->modificarDiscos($id,$numerohard,$refpeliculas,$refestados); 
	
	if ($res == true) { 
	echo ''; 
	} else { 
	echo 'Hubo un error al modificar datos'; 
	} 
	} 
	
	function eliminarDiscos($serviciosReferencias) { 
	$id = $_POST['id']; 
	
	$res = $serviciosReferencias->eliminarDiscos($id); 
	
	echo $res; 
	} 
	
	function insertarPeliculas($serviciosReferencias) { 
	$titulo = $_POST['titulo']; 
	$fechaestreno = $_POST['fechaestreno']; 
	$refclientes = $_POST['refclientes']; 
	
	
	$res = $serviciosReferencias->insertarPeliculas($titulo,$fechaestreno,$refclientes); 
	
	if ((integer)$res > 0) { 
	echo ''; 
	} else { 
	echo 'Hubo un error al insertar datos';	 
	} 
	} 
	
	function modificarPeliculas($serviciosReferencias) { 
	$id = $_POST['id']; 
	$titulo = $_POST['titulo']; 
	$fechaestreno = $_POST['fechaestreno']; 
	$refclientes = $_POST['refclientes']; 
	
	
	$res = $serviciosReferencias->modificarPeliculas($id,$titulo,$fechaestreno,$refclientes); 
	
	if ($res == true) { 
	echo ''; 
	} else { 
	echo 'Hubo un error al modificar datos'; 
	} 
	} 
	
	function eliminarPeliculas($serviciosReferencias) { 
	$id = $_POST['id']; 
	
	$res = $serviciosReferencias->eliminarPeliculas($id); 
	
	echo $res; 
	} 
	
	function insertarPrestatarios($serviciosReferencias) { 
	$razonsocial = $_POST['razonsocial']; 
	$nombre = $_POST['nombre']; 
	$telefono = $_POST['telefono']; 
	$direccion = $_POST['direccion']; 
	$email = $_POST['email']; 
	$localidad = $_POST['localidad']; 
	$provincia = $_POST['provincia']; 
	
	
	$res = $serviciosReferencias->insertarPrestatarios($razonsocial,$nombre,$telefono,$direccion,$email,$localidad,$provincia); 
	
	if ((integer)$res > 0) { 
	echo ''; 
	} else { 
	echo 'Hubo un error al insertar datos';	 
	} 
	} 
	
	function modificarPrestatarios($serviciosReferencias) { 
	$id = $_POST['id']; 
	$razonsocial = $_POST['razonsocial']; 
	$nombre = $_POST['nombre']; 
	$telefono = $_POST['telefono']; 
	$direccion = $_POST['direccion']; 
	$email = $_POST['email']; 
	$localidad = $_POST['localidad']; 
	$provincia = $_POST['provincia']; 
	
	
	$res = $serviciosReferencias->modificarPrestatarios($id,$razonsocial,$nombre,$telefono,$direccion,$email,$localidad,$provincia); 
	
	if ($res == true) { 
	echo ''; 
	} else { 
	echo 'Hubo un error al modificar datos'; 
	} 
	} 
	
	function eliminarPrestatarios($serviciosReferencias) { 
	$id = $_POST['id']; 
	
	$res = $serviciosReferencias->eliminarPrestatarios($id); 
	
	echo $res; 
	} 
	
	function insertarUsuarios($serviciosReferencias) { 
	$usuario = $_POST['usuario']; 
	$password = $_POST['password']; 
	$refroles = $_POST['refroles']; 
	$email = $_POST['email']; 
	$nombrecompleto = $_POST['nombrecompleto']; 
	
	
	$res = $serviciosReferencias->insertarUsuarios($usuario,$password,$refroles,$email,$nombrecompleto); 
	
	if ((integer)$res > 0) { 
	echo ''; 
	} else { 
	echo 'Hubo un error al insertar datos';	 
	} 
	} 
	
	function modificarUsuarios($serviciosReferencias) { 
	$id = $_POST['id']; 
	$usuario = $_POST['usuario']; 
	$password = $_POST['password']; 
	$refroles = $_POST['refroles']; 
	$email = $_POST['email']; 
	$nombrecompleto = $_POST['nombrecompleto']; 
	
	
	$res = $serviciosReferencias->modificarUsuarios($id,$usuario,$password,$refroles,$email,$nombrecompleto); 
	
	if ($res == true) { 
	echo ''; 
	} else { 
	echo 'Hubo un error al modificar datos'; 
	} 
	} 
	
	function eliminarUsuarios($serviciosReferencias) { 
	$id = $_POST['id']; 
	
	$res = $serviciosReferencias->eliminarUsuarios($id); 
	
	echo $res; 
	} 
	
	function insertarPredio_menu($serviciosReferencias) { 
	$url = $_POST['url']; 
	$icono = $_POST['icono']; 
	$nombre = $_POST['nombre']; 
	$Orden = $_POST['Orden']; 
	$hover = $_POST['hover']; 
	$permiso = $_POST['permiso']; 
	
	
	$res = $serviciosReferencias->insertarPredio_menu($url,$icono,$nombre,$Orden,$hover,$permiso); 
	
	if ((integer)$res > 0) { 
	echo ''; 
	} else { 
	echo 'Hubo un error al insertar datos';	 
	} 
	} 
	
	function modificarPredio_menu($serviciosReferencias) { 
	$id = $_POST['id']; 
	$url = $_POST['url']; 
	$icono = $_POST['icono']; 
	$nombre = $_POST['nombre']; 
	$Orden = $_POST['Orden']; 
	$hover = $_POST['hover']; 
	$permiso = $_POST['permiso']; 
	
	
	$res = $serviciosReferencias->modificarPredio_menu($id,$url,$icono,$nombre,$Orden,$hover,$permiso); 
	
	if ($res == true) { 
	echo ''; 
	} else { 
	echo 'Hubo un error al modificar datos'; 
	} 
	} 
	
	function eliminarPredio_menu($serviciosReferencias) { 
	$id = $_POST['id']; 
	
	$res = $serviciosReferencias->eliminarPredio_menu($id); 
	
	echo $res; 
	} 
	
	function insertarEstados($serviciosReferencias) { 
	$estado = $_POST['estado']; 
	
	
	$res = $serviciosReferencias->insertarEstados($estado); 
	
	if ((integer)$res > 0) { 
	echo ''; 
	} else { 
	echo 'Hubo un error al insertar datos';	 
	} 
	} 
	
	function modificarEstados($serviciosReferencias) { 
	$id = $_POST['id']; 
	$estado = $_POST['estado']; 
	
	
	$res = $serviciosReferencias->modificarEstados($id,$estado); 
	
	if ($res == true) { 
	echo ''; 
	} else { 
	echo 'Hubo un error al modificar datos'; 
	} 
	} 
	
	function eliminarEstados($serviciosReferencias) { 
	$id = $_POST['id']; 
	
	$res = $serviciosReferencias->eliminarEstados($id); 
	
	echo $res; 
	} 
	
	function insertarMoviles($serviciosReferencias) { 
	$movil = $_POST['movil']; 
	$placa = $_POST['placa']; 
	$descripcion = $_POST['descripcion']; 
	
	
	$res = $serviciosReferencias->insertarMoviles($movil,$placa,$descripcion); 
	
	if ((integer)$res > 0) { 
	echo ''; 
	} else { 
	echo 'Hubo un error al insertar datos';	 
	} 
	} 
	
	function modificarMoviles($serviciosReferencias) { 
	$id = $_POST['id']; 
	$movil = $_POST['movil']; 
	$placa = $_POST['placa']; 
	$descripcion = $_POST['descripcion']; 
	
	
	$res = $serviciosReferencias->modificarMoviles($id,$movil,$placa,$descripcion); 
	
	if ($res == true) { 
	echo ''; 
	} else { 
	echo 'Hubo un error al modificar datos'; 
	} 
	} 
	
	function eliminarMoviles($serviciosReferencias) { 
	$id = $_POST['id']; 
	
	$res = $serviciosReferencias->eliminarMoviles($id); 
	
	echo $res; 
	} 
	
	function insertarRoles($serviciosReferencias) { 
	$descripcion = $_POST['descripcion']; 
	if (isset($_POST['activo'])) { 
	$activo	= 1; 
	} else { 
	$activo = 0; 
	} 
	
	
	$res = $serviciosReferencias->insertarRoles($descripcion,$activo); 
	
	if ((integer)$res > 0) { 
	echo ''; 
	} else { 
	echo 'Hubo un error al insertar datos';	 
	} 
	} 
	
	function modificarRoles($serviciosReferencias) { 
	$id = $_POST['id']; 
	$descripcion = $_POST['descripcion']; 
	if (isset($_POST['activo'])) { 
	$activo	= 1; 
	} else { 
	$activo = 0; 
	} 
	
	
	$res = $serviciosReferencias->modificarRoles($id,$descripcion,$activo); 
	
	if ($res == true) { 
	echo ''; 
	} else { 
	echo 'Hubo un error al modificar datos'; 
	} 
	} 
	
	function eliminarRoles($serviciosReferencias) { 
	$id = $_POST['id']; 
	
	$res = $serviciosReferencias->eliminarRoles($id); 
	
	echo $res; 
	} 
	
	function insertarTransporteterceros($serviciosReferencias) { 
	$razonsocial = $_POST['razonsocial']; 
	$telefono = $_POST['telefono']; 
	$email = $_POST['email']; 
	
	
	$res = $serviciosReferencias->insertarTransporteterceros($razonsocial,$telefono,$email); 
	
	if ((integer)$res > 0) { 
	echo ''; 
	} else { 
	echo 'Hubo un error al insertar datos';	 
	} 
	} 
	
	function modificarTransporteterceros($serviciosReferencias) { 
	$id = $_POST['id']; 
	$razonsocial = $_POST['razonsocial']; 
	$telefono = $_POST['telefono']; 
	$email = $_POST['email']; 
	
	
	$res = $serviciosReferencias->modificarTransporteterceros($id,$razonsocial,$telefono,$email); 
	
	if ($res == true) { 
	echo ''; 
	} else { 
	echo 'Hubo un error al modificar datos'; 
	} 
	} 
	
	function eliminarTransporteterceros($serviciosReferencias) { 
	$id = $_POST['id']; 
	
	$res = $serviciosReferencias->eliminarTransporteterceros($id); 
	
	echo $res; 
	} 
	
	
	/* Fin */

////////////////////////// FIN DE TRAER DATOS ////////////////////////////////////////////////////////////

//////////////////////////  BASICO  /////////////////////////////////////////////////////////////////////////

function toArray($query)
{
    $res = array();
    while ($row = @mysql_fetch_array($query)) {
        $res[] = $row;
    }
    return $res;
}

function existe($serviciosReferencias) {
	$busqueda 	= $_POST['busqueda'];
	$idtabla 	= $_POST['idtabla'];
	$campo 		= $_POST['campo'];

	$res = $serviciosReferencias->existe($busqueda, $idtabla,$campo);

	if (mysql_num_rows($res)>0) {
		echo 'Si';
	} else {
		echo 'No';
	}
}


function entrar($serviciosUsuarios) {
	$email		=	$_POST['email'];
	$pass		=	$_POST['pass'];
	echo $serviciosUsuarios->loginUsuario($email,$pass);
}


function registrar($serviciosUsuarios) {
	$usuario			=	$_POST['usuario'];
	$password			=	$_POST['password'];
	$refroll			=	$_POST['refroll'];
	$email				=	$_POST['email'];
	$nombre				=	$_POST['nombrecompleto'];
	
	$res = $serviciosUsuarios->insertarUsuario($usuario,$password,$refroll,$email,$nombre);
	if ((integer)$res > 0) {
		echo '';	
	} else {
		echo $res;	
	}
}


function insertarUsuario($serviciosUsuarios) {
	$usuario			=	$_POST['usuario'];
	$password			=	$_POST['password'];
	$refroll			=	$_POST['refroles'];
	$email				=	$_POST['email'];
	$nombre				=	$_POST['nombrecompleto'];
	
	$res = $serviciosUsuarios->insertarUsuario($usuario,$password,$refroll,$email,$nombre);
	if ((integer)$res > 0) {
		echo '';	
	} else {
		echo $res;	
	}
}


function modificarUsuario($serviciosUsuarios) {
	$id					=	$_POST['id'];
	$usuario			=	$_POST['usuario'];
	$password			=	$_POST['password'];
	$refroll			=	$_POST['refroles'];
	$email				=	$_POST['email'];
	$nombre				=	$_POST['nombrecompleto'];
	
	echo $serviciosUsuarios->modificarUsuario($id,$usuario,$password,$refroll,$email,$nombre);
}


function enviarMail($serviciosUsuarios) {
	$email		=	$_POST['email'];
	$pass		=	$_POST['pass'];
	//$idempresa  =	$_POST['idempresa'];
	
	echo $serviciosUsuarios->login($email,$pass);
}


function devolverImagen($nroInput) {
	
	if( $_FILES['archivo'.$nroInput]['name'] != null && $_FILES['archivo'.$nroInput]['size'] > 0 ){
	// Nivel de errores
	  error_reporting(E_ALL);
	  $altura = 100;
	  // Constantes
	  # Altura de el thumbnail en píxeles
	  //define("ALTURA", 100);
	  # Nombre del archivo temporal del thumbnail
	  //define("NAMETHUMB", "/tmp/thumbtemp"); //Esto en servidores Linux, en Windows podría ser:
	  //define("NAMETHUMB", "c:/windows/temp/thumbtemp"); //y te olvidas de los problemas de permisos
	  $NAMETHUMB = "c:/windows/temp/thumbtemp";
	  # Servidor de base de datos
	  //define("DBHOST", "localhost");
	  # nombre de la base de datos
	  //define("DBNAME", "portalinmobiliario");
	  # Usuario de base de datos
	  //define("DBUSER", "root");
	  # Password de base de datos
	  //define("DBPASSWORD", "");
	  // Mime types permitidos
	  $mimetypes = array("image/jpeg", "image/pjpeg", "image/gif", "image/png");
	  // Variables de la foto
	  $name = $_FILES["archivo".$nroInput]["name"];
	  $type = $_FILES["archivo".$nroInput]["type"];
	  $tmp_name = $_FILES["archivo".$nroInput]["tmp_name"];
	  $size = $_FILES["archivo".$nroInput]["size"];
	  // Verificamos si el archivo es una imagen válida
	  if(!in_array($type, $mimetypes))
		die("El archivo que subiste no es una imagen válida");
	  // Creando el thumbnail
	  switch($type) {
		case $mimetypes[0]:
		case $mimetypes[1]:
		  $img = imagecreatefromjpeg($tmp_name);
		  break;
		case $mimetypes[2]:
		  $img = imagecreatefromgif($tmp_name);
		  break;
		case $mimetypes[3]:
		  $img = imagecreatefrompng($tmp_name);
		  break;
	  }
	  
	  $datos = getimagesize($tmp_name);
	  
	  $ratio = ($datos[1]/$altura);
	  $ancho = round($datos[0]/$ratio);
	  $thumb = imagecreatetruecolor($ancho, $altura);
	  imagecopyresized($thumb, $img, 0, 0, 0, 0, $ancho, $altura, $datos[0], $datos[1]);
	  switch($type) {
		case $mimetypes[0]:
		case $mimetypes[1]:
		  imagejpeg($thumb, $NAMETHUMB);
			  break;
		case $mimetypes[2]:
		  imagegif($thumb, $NAMETHUMB);
		  break;
		case $mimetypes[3]:
		  imagepng($thumb, $NAMETHUMB);
		  break;
	  }
	  // Extrae los contenidos de las fotos
	  # contenido de la foto original
	  $fp = fopen($tmp_name, "rb");
	  $tfoto = fread($fp, filesize($tmp_name));
	  $tfoto = addslashes($tfoto);
	  fclose($fp);
	  # contenido del thumbnail
	  $fp = fopen($NAMETHUMB, "rb");
	  $tthumb = fread($fp, filesize($NAMETHUMB));
	  $tthumb = addslashes($tthumb);
	  fclose($fp);
	  // Borra archivos temporales si es que existen
	  //@unlink($tmp_name);
	  //@unlink(NAMETHUMB);
	} else {
		$tfoto = '';
		$type = '';
	}
	$tfoto = utf8_decode($tfoto);
	return array('tfoto' => $tfoto, 'type' => $type);	
}


?>