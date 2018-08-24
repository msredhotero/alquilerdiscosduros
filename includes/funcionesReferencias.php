<?php

/**
 * @Usuarios clase en donde se accede a la base de datos
 * @ABM consultas sobre las tablas de usuarios y usarios-clientes
 */

date_default_timezone_set('America/Buenos_Aires');

class ServiciosReferencias {

function GUID()
{
    if (function_exists('com_create_guid') === true)
    {
        return trim(com_create_guid(), '{}');
    }

    return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
}

///**********  PARA SUBIR ARCHIVOS  ***********************//////////////////////////
	function borrarDirecctorio($dir) {
		array_map('unlink', glob($dir."/*.*"));	
	
	}
	
	function borrarArchivo($id,$archivo) {
		$sql	=	"delete from dbfotos where idfoto =".$id;
		
		$res =  unlink("./../archivos/".$archivo);
		if ($res)
		{
			$this->query($sql,0);	
		}
		return $res;
	}
	
	
	function existeArchivo($refinmueble,$nombre,$type) {
		$sql		=	"select * from dbfotos where refnoticia =".$refinmueble." and imagen = '".$nombre."' and type = '".$type."'";
		$resultado  =   $this->query($sql,0);
			   
			   if(mysql_num_rows($resultado)>0){
	
				   return mysql_result($resultado,0,0);
	
			   }
	
			   return 0;	
	}


	function subirArchivo($file,$carpeta,$idInmueble) {
		$dir_destino = '../archivos/'.$carpeta.'/'.$idInmueble.'/';
		$imagen_subida = $dir_destino . (str_replace(' ','',basename($_FILES[$file]['name'])));
		
		$noentrar = '../imagenes/index.php';
		$nuevo_noentrar = '../archivos/'.$carpeta.'/'.$idInmueble.'/'.'index.php';
		
		if (!file_exists($dir_destino)) {
			mkdir($dir_destino, 0777);
		}
		
		 
		if(!is_writable($dir_destino)){
			
			echo "no tiene permisos";
			
		}	else	{
			if ($_FILES[$file]['tmp_name'] != '') {
				if(is_uploaded_file($_FILES[$file]['tmp_name'])){
					/*echo "Archivo ". $_FILES['foto']['name'] ." subido con éxtio.\n";
					echo "Mostrar contenido\n";
					echo $imagen_subida;*/
					if (move_uploaded_file($_FILES[$file]['tmp_name'], $imagen_subida)) {
						
						$archivo = ($_FILES[$file]["name"]);
						$tipoarchivo = $_FILES[$file]["type"];
						
						if ($this->existeArchivo($idInmueble,$archivo,$tipoarchivo) == 0) {
							$sql	=	"insert into dbfotos(idfoto,refnoticia,imagen,type) values ('',".$idInmueble.",'".str_replace(' ','',$archivo)."','".$tipoarchivo."')";
							$this->query($sql,1);
						}
						echo "";
						
						copy($noentrar, $nuevo_noentrar);
		
					} else {
						echo "Posible ataque de carga de archivos!\n";
					}
				}else{
					echo "Posible ataque del archivo subido: ";
					echo "nombre del archivo '". $_FILES[$file]['tmp_name'] . "'.";
				}
			}
		}	
	}


	
	function TraerFotosNoticias($idNoticia) {
		$sql    =   "select 'galeria',i.idreclamo,f.imagen,f.idfoto,concat('galeria','/',i.idreclamo,'/',f.imagen) as archivo
							from dbreclamos i
							
							inner
							join dbfotos f
							on	i.idreclamo = f.refnoticia

							where i.idreclamo = ".$idNoticia;
		$result =   $this->query($sql, 0);
		return $result;
	}
	
	
	function eliminarFoto($id)
	{
		
		$sql		=	"select concat('galeria','/',i.idreclamo,'/',f.imagen) as archivo
							from dbreclamos i
							
							inner
							join dbfotos f
							on	i.idreclamo = f.refnoticia

							where f.idfoto =".$id;
		$resImg		=	$this->query($sql,0);
		
		$res 		=	$this->borrarArchivo($id,mysql_result($resImg,0,0));
		
		if ($res == false) {
			return 'Error al eliminar datos';
		} else {
			return '';
		}
	}

/* fin archivos */


/* PARA Alquileres */

function insertarAlquileres($fechaentrega,$metodoentrega,$refmoviles,$reftransporteterceros,$numeroguia,$fechadevolucion,$refdiscos) { 
	$sql = "insert into dbalquileres(idalquiler,fechaentrega,metodoentrega,refmoviles,reftransporteterceros,numeroguia,fechadevolucion,refdiscos) 
	values ('','".($fechaentrega)."',".$metodoentrega.",".($refmoviles == '' ? 0 : $refmoviles).",".($reftransporteterceros == '' ? 0 : $reftransporteterceros).",'".($numeroguia)."','".($fechadevolucion)."',".$refdiscos.")"; 
	$res = $this->query($sql,1); 
	return $res; 
	} 
	
	
	function modificarAlquileres($id,$fechaentrega,$metodoentrega,$refmoviles,$reftransporteterceros,$numeroguia,$fechadevolucion,$refdiscos) { 
	$sql = "update dbalquileres 
	set 
	fechaentrega = '".($fechaentrega)."',metodoentrega = ".$metodoentrega.",refmoviles = ".$refmoviles.",reftransporteterceros = ".$reftransporteterceros.",numeroguia = '".($numeroguia)."',fechadevolucion = '".($fechadevolucion)."',refdiscos = ".$refdiscos." 
	where idalquiler =".$id; 
	$res = $this->query($sql,0); 
	return $res; 
	} 
	
	
	function eliminarAlquileres($id) { 

		$resAlquiler = $this->traerAlquileresPorId($id);

		$this->modificarEstadoDiscos(mysql_result($resAlquiler,0,'refdiscos') ,1);

		$sqlCascada = 'delete from dbalquileresprestatarios where refalquileres = '.$id;
		$res = $this->query($sqlCascada,0); 

		$sql = "delete from dbalquileres where idalquiler =".$id; 
		$res = $this->query($sql,0); 
		return $res; 
	} 
	
	
	function traerAlquileres() { 
	$sql = "select 
	a.idalquiler,
	a.fechaentrega,
	a.metodoentrega,
	a.refmoviles,
	a.reftransporteterceros,
	a.numeroguia,
	a.fechadevolucion,
	a.fechacreacion
	from dbalquileres a 
	order by 1"; 
	$res = $this->query($sql,0); 
	return $res; 
	} 


	function traerAlquileresGrid() { 
		$sql = "select 
		a.idalquiler,
		pp.titulo,
		d.numerohard,
		a.fechaentrega,
		(case when a.metodoentrega = 1 then 'Movil' else 'Transporte Terceros' end) as metodoentrega,
		m.movil,
		t.razonsocial as terceros,
		a.numeroguia,
		a.fechadevolucion,
		a.fechacreacion,
		a.refmoviles,
		a.reftransporteterceros
		from dbalquileres a 
		left join tbmoviles m on m.idmovil = a.refmoviles
		left join tbtransporteterceros t on t.idtransportetercero = a.reftransporteterceros
		inner join dbdiscos d on d.iddisco = a.refdiscos
		inner join dbpeliculas pp on pp.idpelicula = d.refpeliculas
		order by 1"; 
		$res = $this->query($sql,0); 
		return $res; 
	} 
	
	
	function traerAlquileresPorId($id) { 
	$sql = "select idalquiler, date_format( fechaentrega, '%d/%m/%Y') as fechaentrega,metodoentrega,refmoviles,reftransporteterceros,numeroguia,date_format( fechadevolucion, '%d/%m/%Y') as fechadevolucion,fechacreacion,refdiscos from dbalquileres where idalquiler =".$id; 
	$res = $this->query($sql,0); 
	return $res; 
	} 


	
	/* Fin */
	/* /* Fin de la Tabla: dbalquileres*/
	
	
	/* PARA Alquileresprestatarios */
	
	function insertarAlquileresprestatarios($refalquileres,$refprestatarios) { 
	$sql = "insert into dbalquileresprestatarios(idalquilerprestatario,refalquileres,refprestatarios) 
	values ('',".$refalquileres.",".$refprestatarios.")"; 
	$res = $this->query($sql,1); 
	return $res; 
	} 
	
	
	function modificarAlquileresprestatarios($id,$refalquileres,$refprestatarios) { 
	$sql = "update dbalquileresprestatarios 
	set 
	refalquileres = ".$refalquileres.",refprestatarios = ".$refprestatarios." 
	where idalquilerprestatario =".$id; 
	$res = $this->query($sql,0); 
	return $res; 
	} 
	
	
	function eliminarAlquileresprestatarios($id) { 
	$sql = "delete from dbalquileresprestatarios where idalquilerprestatario =".$id; 
	$res = $this->query($sql,0); 
	return $res; 
	} 

	function eliminarAlquileresprestatariosPorAlquiler($id) { 
		$sql = "delete from dbalquileresprestatarios where refalquileres =".$id; 
		$res = $this->query($sql,0); 
		return $res; 
		} 
	
	
	function traerAlquileresprestatarios() { 
	$sql = "select 
	a.idalquilerprestatario,
	a.refalquileres,
	a.refprestatarios
	from dbalquileresprestatarios a 
	inner join dbalquileres alq ON alq.idalquiler = a.refalquileres 
	inner join dbprestatarios pre ON pre.idprestatario = a.refprestatarios 
	order by 1"; 
	$res = $this->query($sql,0); 
	return $res; 
	} 

	function traerAlquileresprestatariosPorAlquiler($id) { 
		$sql = "select 
		a.idalquilerprestatario,
		pre.razonsocial as prestatario,
		a.refalquileres,
		a.refprestatarios
		from dbalquileresprestatarios a 
		inner join dbalquileres alq ON alq.idalquiler = a.refalquileres 
		inner join dbprestatarios pre ON pre.idprestatario = a.refprestatarios 
		where a.refalquileres = ".$id."
		order by 1"; 
		$res = $this->query($sql,0); 
		return $res; 
	} 


	function traerAlquileresprestatariosPorPrestatario($id) { 
		$sql = "select 
		a.idalquilerprestatario,
		pe.titulo,
		d.numerohard,
		a.refalquileres,
		a.refprestatarios
		from dbalquileresprestatarios a 
		inner join dbalquileres alq ON alq.idalquiler = a.refalquileres 
		inner join dbdiscos d on d.iddisco = alq.refdiscos
		inner join dbpeliculas pe on pe.idpelicula = d.refpeliculas
		inner join dbprestatarios pre ON pre.idprestatario = a.refprestatarios 
		where a.refprestatarios = ".$id." and d.refestados in (2,3,4)
		order by 1"; 
		$res = $this->query($sql,0); 
		return $res; 
	} 
	
	
	function traerAlquileresprestatariosPorId($id) { 
	$sql = "select idalquilerprestatario,refalquileres,refprestatarios from dbalquileresprestatarios where idalquilerprestatario =".$id; 
	$res = $this->query($sql,0); 
	return $res; 
	} 
	
	/* Fin */
	/* /* Fin de la Tabla: dbalquileresprestatarios*/
	
	
	/* PARA Clientes */
	
	function insertarClientes($razonsocial,$cuit,$telefono,$email,$direccion,$provincia,$ciudad) { 
	$sql = "insert into dbclientes(idcliente,razonsocial,cuit,telefono,email,direccion,provincia,ciudad) 
	values ('','".($razonsocial)."','".($cuit)."','".($telefono)."','".($email)."','".($direccion)."','".($provincia)."','".($ciudad)."')"; 
	$res = $this->query($sql,1); 
	return $res; 
	} 
	
	
	function modificarClientes($id,$razonsocial,$cuit,$telefono,$email,$direccion,$provincia,$ciudad) { 
	$sql = "update dbclientes 
	set 
	razonsocial = '".($razonsocial)."',cuit = '".($cuit)."',telefono = '".($telefono)."',email = '".($email)."',direccion = '".($direccion)."',provincia = '".($provincia)."',ciudad = '".($ciudad)."' 
	where idcliente =".$id; 
	$res = $this->query($sql,0); 
	return $res; 
	} 
	
	
	function eliminarClientes($id) { 
	$sql = "delete from dbclientes where idcliente =".$id; 
	$res = $this->query($sql,0); 
	return $res; 
	} 
	
	
	function traerClientes() { 
	$sql = "select 
	c.idcliente,
	c.razonsocial,
	c.cuit,
	c.telefono,
	c.email,
	c.direccion,
	c.provincia,
	c.ciudad
	from dbclientes c 
	order by 1"; 
	$res = $this->query($sql,0); 
	return $res; 
	} 
	
	
	function traerClientesPorId($id) { 
	$sql = "select idcliente,razonsocial,cuit,telefono,email,direccion,provincia,ciudad from dbclientes where idcliente =".$id; 
	$res = $this->query($sql,0); 
	return $res; 
	} 
	
	/* Fin */
	/* /* Fin de la Tabla: dbclientes*/
	
	
	/* PARA Devoluciones */
	
	function insertarDevoluciones($refprestatarios,$metodoentrega,$refmoviles,$reftransporteterceros,$numeroguia,$fechadevolucion,$aldeposito,$observaciones) { 
	$sql = "insert into dbdevoluciones(iddevolucion,refprestatarios,metodoentrega,refmoviles,reftransporteterceros,numeroguia,fechadevolucion,aldeposito,observaciones) 
	values ('',".$refprestatarios.",".$metodoentrega.",".$refmoviles.",".$reftransporteterceros.",'".($numeroguia)."','".($fechadevolucion)."',".$aldeposito.",'".($observaciones)."')"; 
	$res = $this->query($sql,1); 
	return $res; 
	} 
	
	
	function modificarDevoluciones($id,$refprestatarios,$metodoentrega,$refmoviles,$reftransporteterceros,$numeroguia,$fechadevolucion,$aldeposito,$observaciones) { 
	$sql = "update dbdevoluciones 
	set 
	refprestatarios = ".$refprestatarios.",metodoentrega = ".$metodoentrega.",refmoviles = ".$refmoviles.",reftransporteterceros = ".$reftransporteterceros.",numeroguia = '".($numeroguia)."',fechadevolucion = '".($fechadevolucion)."',aldeposito = ".$aldeposito.",observaciones = '".($observaciones)."' 
	where iddevolucion =".$id; 
	$res = $this->query($sql,0); 
	return $res; 
	} 
	
	
	function eliminarDevoluciones($id) { 
	$sql = "delete from dbdevoluciones where iddevolucion =".$id; 
	$res = $this->query($sql,0); 
	return $res; 
	} 
	
	
	function traerDevoluciones() { 
	$sql = "select 
	d.iddevolucion,
	d.refprestatarios,
	d.metodoentrega,
	d.refmoviles,
	d.reftransporteterceros,
	d.numeroguia,
	d.fechadevolucion,
	d.aldeposito,
	d.observaciones
	from dbdevoluciones d 
	inner join dbprestatarios pre ON pre.idprestatario = d.refprestatarios 
	order by 1"; 
	$res = $this->query($sql,0); 
	return $res; 
	} 
	
	
	function traerDevolucionesPorId($id) { 
	$sql = "select iddevolucion,refprestatarios,metodoentrega,refmoviles,reftransporteterceros,numeroguia,fechadevolucion,aldeposito,observaciones from dbdevoluciones where iddevolucion =".$id; 
	$res = $this->query($sql,0); 
	return $res; 
	} 
	
	/* Fin */
	/* /* Fin de la Tabla: dbdevoluciones*/
	
	
	/* PARA Discos */
	
	function insertarDiscos($numerohard,$refpeliculas,$refestados) { 
	$sql = "insert into dbdiscos(iddisco,numerohard,refpeliculas,refestados) 
	values ('',".$numerohard.",".$refpeliculas.",1)"; 
	$res = $this->query($sql,1); 
	return $res; 
	} 
	
	
	function modificarDiscos($id,$numerohard,$refpeliculas,$refestados) { 
	$sql = "update dbdiscos 
	set 
	numerohard = ".$numerohard.",refpeliculas = ".$refpeliculas." , refestados= ".$refestados."
	where iddisco =".$id; 
	$res = $this->query($sql,0); 
	return $res; 
	} 

	function modificarEstadoDiscos($id,$refestados) { 
		$sql = "update dbdiscos 
		set 
			refestados= ".$refestados."
		where iddisco =".$id; 
		$res = $this->query($sql,0); 
		return $res; 
	} 
	
	
	function eliminarDiscos($id) { 
	$sql = "delete from dbdiscos where iddisco =".$id; 
	$res = $this->query($sql,0); 
	return $res; 
	} 
	
	
	function traerDiscos() { 
	$sql = "select 
	d.iddisco,
	d.numerohard,
	d.refpeliculas,
	d.refestados
	from dbdiscos d 
	inner join dbpeliculas pel ON pel.idpelicula = d.refpeliculas 
	inner join dbclientes cl ON cl.idcliente = pel.refclientes 
	order by 1"; 
	$res = $this->query($sql,0); 
	return $res; 
	} 


	function traerDiscosDeposito() { 
		$sql = "select 
		d.iddisco,
		d.numerohard,
		pel.titulo,
		d.refpeliculas,
		d.refestados
		from dbdiscos d 
		inner join dbpeliculas pel ON pel.idpelicula = d.refpeliculas 
		inner join dbclientes cl ON cl.idcliente = pel.refclientes 
		where d.refestados = 1
		order by 1"; 
		$res = $this->query($sql,0); 
		return $res; 
	} 


	function traerDiscosGrid() { 
	$sql = "select 
	d.iddisco,
	d.numerohard,
	pel.titulo,
	e.estado,
	d.refpeliculas,
	d.refestados
	from dbdiscos d 
	inner join dbpeliculas pel ON pel.idpelicula = d.refpeliculas 
	inner join dbclientes cl ON cl.idcliente = pel.refclientes 
	inner join tbestados e ON e.idestado = d.refestados
	order by 1"; 
	$res = $this->query($sql,0); 
	return $res; 
	} 


	function traerDiscosGridPorId($id) { 
		$sql = "select 
		d.iddisco,
		d.numerohard,
		pel.titulo,
		e.estado,
		d.refpeliculas,
		d.refestados
		from dbdiscos d 
		inner join dbpeliculas pel ON pel.idpelicula = d.refpeliculas 
		inner join dbclientes cl ON cl.idcliente = pel.refclientes 
		inner join tbestados e ON e.idestado = d.refestados
		where d.iddisco =".$id; 
		$res = $this->query($sql,0); 
		return $res; 
		} 
	
	
	function traerDiscosPorId($id) { 
	$sql = "select iddisco,numerohard,refpeliculas,refestados from dbdiscos where iddisco =".$id; 
	$res = $this->query($sql,0); 
	return $res; 
	} 


	function traerDiscosPorNro($numerohard) { 
		$sql = "select iddisco,numerohard,refpeliculas,refestados from dbdiscos where numerohard =".$numerohard; 
		$res = $this->query($sql,0); 
		return $res; 
	} 

	function traerFechaEstrenoPorDisco($id, $fechaentrega) {
		if ($fechaentrega == '') {
			$sql = "select 
					DATE_FORMAT(DATE_ADD(pel.fechaestreno, INTERVAL 15 DAY),'%d/%m/%Y') as fechadevolucion
					from dbdiscos d 
					inner join dbpeliculas pel ON pel.idpelicula = d.refpeliculas 
					where d.iddisco =".$id; 
		} else {
			$sql = "select 
					(case when '".$fechaentrega."' > pel.fechaestreno then 
						DATE_FORMAT(DATE_ADD('".$fechaentrega."', INTERVAL 15 DAY),'%d/%m/%Y')
						else
						DATE_FORMAT(DATE_ADD(pel.fechaestreno, INTERVAL 15 DAY),'%d/%m/%Y')
					end) as fechadevolucion
					from dbdiscos d 
					inner join dbpeliculas pel ON pel.idpelicula = d.refpeliculas 
					where d.iddisco =".$id; 
		}
		
		$res = $this->query($sql,0); 

		if (mysql_num_rows($res)>0) {
			return mysql_result($res,0,0);
		}
		return date('Y-m-d'); 
	}

	function traerUltimoNroHardPorPelicula($idpelicula) {
		$sql = "select max(numerohard) from dbdiscos where refpeliculas =".$idpelicula;

		$res = $this->query($sql,0); 

		if (mysql_num_rows($res)>0) {
			return mysql_result($res,0,0);
		}
		return 0; 
	}

	
	/* Fin */
	/* /* Fin de la Tabla: dbdiscos*/
	
	
	/* PARA Peliculas */
	
	function insertarPeliculas($titulo,$fechaestreno,$refclientes) { 
	$sql = "insert into dbpeliculas(idpelicula,titulo,fechaestreno,refclientes) 
	values ('','".($titulo)."','".($fechaestreno)."',".$refclientes.")"; 
	$res = $this->query($sql,1); 
	return $res; 
	} 
	
	
	function modificarPeliculas($id,$titulo,$fechaestreno,$refclientes) { 
	$sql = "update dbpeliculas 
	set 
	titulo = '".($titulo)."',fechaestreno = '".($fechaestreno)."',refclientes = ".$refclientes." 
	where idpelicula =".$id; 
	$res = $this->query($sql,0); 
	return $res; 
	} 
	
	
	function eliminarPeliculas($id) { 
	$sql = "delete from dbpeliculas where idpelicula =".$id; 
	$res = $this->query($sql,0); 
	return $res; 
	} 
	
	
	function traerPeliculas() { 
	$sql = "select 
	p.idpelicula,
	p.titulo,
	p.fechaestreno,
	p.refclientes
	from dbpeliculas p 
	inner join dbclientes cli ON cli.idcliente = p.refclientes 
	order by 1"; 
	$res = $this->query($sql,0); 
	return $res; 
	} 


	function traerPeliculasGrid() { 
	$sql = "select 
	p.idpelicula,
	p.titulo,
	p.fechaestreno,
	cli.razonsocial,
	p.refclientes
	from dbpeliculas p 
	inner join dbclientes cli ON cli.idcliente = p.refclientes 
	order by 1"; 
	$res = $this->query($sql,0); 
	return $res; 
	} 
	
	
	function traerPeliculasPorId($id) { 
	$sql = "select idpelicula,titulo,fechaestreno,refclientes from dbpeliculas where idpelicula =".$id; 
	$res = $this->query($sql,0); 
	return $res; 
	} 
	
	/* Fin */
	/* /* Fin de la Tabla: dbpeliculas*/
	
	
	/* PARA Prestatarios */
	
	function insertarPrestatarios($razonsocial,$nombre,$telefono,$direccion,$email,$localidad,$provincia) { 
	$sql = "insert into dbprestatarios(idprestatario,razonsocial,nombre,telefono,direccion,email,localidad,provincia) 
	values ('','".($razonsocial)."','".($nombre)."','".($telefono)."','".($direccion)."','".($email)."','".($localidad)."','".($provincia)."')"; 
	$res = $this->query($sql,1); 
	return $res; 
	} 
	
	
	function modificarPrestatarios($id,$razonsocial,$nombre,$telefono,$direccion,$email,$localidad,$provincia) { 
	$sql = "update dbprestatarios 
	set 
	razonsocial = '".($razonsocial)."',nombre = '".($nombre)."',telefono = '".($telefono)."',direccion = '".($direccion)."',email = '".($email)."',localidad = '".($localidad)."',provincia = '".($provincia)."' 
	where idprestatario =".$id; 
	$res = $this->query($sql,0); 
	return $res; 
	} 
	
	
	function eliminarPrestatarios($id) { 
	$sql = "delete from dbprestatarios where idprestatario =".$id; 
	$res = $this->query($sql,0); 
	return $res; 
	} 
	
	
	function traerPrestatarios() { 
	$sql = "select 
	p.idprestatario,
	p.razonsocial,
	p.nombre,
	p.telefono,
	p.direccion,
	p.email,
	p.localidad,
	p.provincia
	from dbprestatarios p 
	order by 1"; 
	$res = $this->query($sql,0); 
	return $res; 
	} 
	
	
	function traerPrestatariosPorId($id) { 
	$sql = "select idprestatario,razonsocial,nombre,telefono,direccion,email,localidad,provincia from dbprestatarios where idprestatario =".$id; 
	$res = $this->query($sql,0); 
	return $res; 
	} 
	
	/* Fin */
	/* /* Fin de la Tabla: dbprestatarios*/
	
	
	/* PARA Usuarios */
	
	function insertarUsuarios($usuario,$password,$refroles,$email,$nombrecompleto) { 
	$sql = "insert into dbusuarios(idusuario,usuario,password,refroles,email,nombrecompleto) 
	values ('','".($usuario)."','".($password)."',".$refroles.",'".($email)."','".($nombrecompleto)."')"; 
	$res = $this->query($sql,1); 
	return $res; 
	} 
	
	
	function modificarUsuarios($id,$usuario,$password,$refroles,$email,$nombrecompleto) { 
	$sql = "update dbusuarios 
	set 
	usuario = '".($usuario)."',password = '".($password)."',refroles = ".$refroles.",email = '".($email)."',nombrecompleto = '".($nombrecompleto)."' 
	where idusuario =".$id; 
	$res = $this->query($sql,0); 
	return $res; 
	} 
	
	
	function eliminarUsuarios($id) { 
	$sql = "delete from dbusuarios where idusuario =".$id; 
	$res = $this->query($sql,0); 
	return $res; 
	} 
	
	
	function traerUsuarios() { 
	$sql = "select 
	u.idusuario,
	u.usuario,
	u.password,
	u.refroles,
	u.email,
	u.nombrecompleto
	from dbusuarios u 
	inner join tbroles rol ON rol.idrol = u.refroles 
	order by 1"; 
	$res = $this->query($sql,0); 
	return $res; 
	} 
	
	
	function traerUsuariosPorId($id) { 
	$sql = "select idusuario,usuario,password,refroles,email,nombrecompleto from dbusuarios where idusuario =".$id; 
	$res = $this->query($sql,0); 
	return $res; 
	} 
	
	/* Fin */
	/* /* Fin de la Tabla: dbusuarios*/
	
	
	/* PARA Predio_menu */
	
	function insertarPredio_menu($url,$icono,$nombre,$Orden,$hover,$permiso) { 
	$sql = "insert into predio_menu(idmenu,url,icono,nombre,Orden,hover,permiso) 
	values ('','".($url)."','".($icono)."','".($nombre)."',".$Orden.",'".($hover)."','".($permiso)."')"; 
	$res = $this->query($sql,1); 
	return $res; 
	} 
	
	
	function modificarPredio_menu($id,$url,$icono,$nombre,$Orden,$hover,$permiso) { 
	$sql = "update predio_menu 
	set 
	url = '".($url)."',icono = '".($icono)."',nombre = '".($nombre)."',Orden = ".$Orden.",hover = '".($hover)."',permiso = '".($permiso)."' 
	where idmenu =".$id; 
	$res = $this->query($sql,0); 
	return $res; 
	} 
	
	
	function eliminarPredio_menu($id) { 
	$sql = "delete from predio_menu where idmenu =".$id; 
	$res = $this->query($sql,0); 
	return $res; 
	} 
	
	
	function traerPredio_menu() { 
	$sql = "select 
	p.idmenu,
	p.url,
	p.icono,
	p.nombre,
	p.Orden,
	p.hover,
	p.permiso
	from predio_menu p 
	order by 1"; 
	$res = $this->query($sql,0); 
	return $res; 
	} 
	
	
	function traerPredio_menuPorId($id) { 
	$sql = "select idmenu,url,icono,nombre,Orden,hover,permiso from predio_menu where idmenu =".$id; 
	$res = $this->query($sql,0); 
	return $res; 
	} 
	
	/* Fin */
	/* /* Fin de la Tabla: predio_menu*/
	
	
	/* PARA Estados */
	
	function insertarEstados($estado) { 
	$sql = "insert into tbestados(idestado,estado) 
	values ('','".($estado)."')"; 
	$res = $this->query($sql,1); 
	return $res; 
	} 
	
	
	function modificarEstados($id,$estado) { 
	$sql = "update tbestados 
	set 
	estado = '".($estado)."' 
	where idestado =".$id; 
	$res = $this->query($sql,0); 
	return $res; 
	} 
	
	
	function eliminarEstados($id) { 
	$sql = "delete from tbestados where idestado =".$id; 
	$res = $this->query($sql,0); 
	return $res; 
	} 
	
	
	function traerEstados() { 
	$sql = "select 
	e.idestado,
	e.estado
	from tbestados e 
	order by 1"; 
	$res = $this->query($sql,0); 
	return $res; 
	} 
	
	
	function traerEstadosPorId($id) { 
	$sql = "select idestado,estado from tbestados where idestado =".$id; 
	$res = $this->query($sql,0); 
	return $res; 
	} 
	
	/* Fin */
	/* /* Fin de la Tabla: tbestados*/
	
	
	/* PARA Moviles */
	
	function insertarMoviles($movil,$placa,$descripcion) { 
	$sql = "insert into tbmoviles(idmovil,movil,placa,descripcion) 
	values ('','".($movil)."','".($placa)."','".($descripcion)."')"; 
	$res = $this->query($sql,1); 
	return $res; 
	} 
	
	
	function modificarMoviles($id,$movil,$placa,$descripcion) { 
	$sql = "update tbmoviles 
	set 
	movil = '".($movil)."',placa = '".($placa)."',descripcion = '".($descripcion)."' 
	where idmovil =".$id; 
	$res = $this->query($sql,0); 
	return $res; 
	} 
	
	
	function eliminarMoviles($id) { 
	$sql = "delete from tbmoviles where idmovil =".$id; 
	$res = $this->query($sql,0); 
	return $res; 
	} 
	
	
	function traerMoviles() { 
	$sql = "select 
	m.idmovil,
	m.movil,
	m.placa,
	m.descripcion
	from tbmoviles m 
	order by 1"; 
	$res = $this->query($sql,0); 
	return $res; 
	} 
	
	
	function traerMovilesPorId($id) { 
	$sql = "select idmovil,movil,placa,descripcion from tbmoviles where idmovil =".$id; 
	$res = $this->query($sql,0); 
	return $res; 
	} 
	
	/* Fin */
	/* /* Fin de la Tabla: tbmoviles*/
	
	
	/* PARA Roles */
	
	function insertarRoles($descripcion,$activo) { 
	$sql = "insert into tbroles(idrol,descripcion,activo) 
	values ('','".($descripcion)."',".$activo.")"; 
	$res = $this->query($sql,1); 
	return $res; 
	} 
	
	
	function modificarRoles($id,$descripcion,$activo) { 
	$sql = "update tbroles 
	set 
	descripcion = '".($descripcion)."',activo = ".$activo." 
	where idrol =".$id; 
	$res = $this->query($sql,0); 
	return $res; 
	} 
	
	
	function eliminarRoles($id) { 
	$sql = "delete from tbroles where idrol =".$id; 
	$res = $this->query($sql,0); 
	return $res; 
	} 
	
	
	function traerRoles() { 
	$sql = "select 
	r.idrol,
	r.descripcion,
	r.activo
	from tbroles r 
	order by 1"; 
	$res = $this->query($sql,0); 
	return $res; 
	} 
	
	
	function traerRolesPorId($id) { 
	$sql = "select idrol,descripcion,activo from tbroles where idrol =".$id; 
	$res = $this->query($sql,0); 
	return $res; 
	} 
	
	/* Fin */
	/* /* Fin de la Tabla: tbroles*/
	
	
	/* PARA Transporteterceros */
	
	function insertarTransporteterceros($razonsocial,$telefono,$email) { 
	$sql = "insert into tbtransporteterceros(idtransportetercero,razonsocial,telefono,email) 
	values ('','".($razonsocial)."','".($telefono)."','".($email)."')"; 
	$res = $this->query($sql,1); 
	return $res; 
	} 
	
	
	function modificarTransporteterceros($id,$razonsocial,$telefono,$email) { 
	$sql = "update tbtransporteterceros 
	set 
	razonsocial = '".($razonsocial)."',telefono = '".($telefono)."',email = '".($email)."' 
	where idtransportetercero =".$id; 
	$res = $this->query($sql,0); 
	return $res; 
	} 
	
	
	function eliminarTransporteterceros($id) { 
	$sql = "delete from tbtransporteterceros where idtransportetercero =".$id; 
	$res = $this->query($sql,0); 
	return $res; 
	} 
	
	
	function traerTransporteterceros() { 
	$sql = "select 
	t.idtransportetercero,
	t.razonsocial,
	t.telefono,
	t.email
	from tbtransporteterceros t 
	order by 1"; 
	$res = $this->query($sql,0); 
	return $res; 
	} 
	
	
	function traerTransportetercerosPorId($id) { 
	$sql = "select idtransportetercero,razonsocial,telefono,email from tbtransporteterceros where idtransportetercero =".$id; 
	$res = $this->query($sql,0); 
	return $res; 
	} 
	
	/* Fin */
	/* /* Fin de la Tabla: tbtransporteterceros*/



function query($sql,$accion) {
		
		
		
		require_once 'appconfig.php';

		$appconfig	= new appconfig();
		$datos		= $appconfig->conexion();	
		$hostname	= $datos['hostname'];
		$database	= $datos['database'];
		$username	= $datos['username'];
		$password	= $datos['password'];
		
		$conex = mysql_connect($hostname,$username,$password) or die ("no se puede conectar".mysql_error());
		
		mysql_select_db($database);
		
		        $error = 0;
		mysql_query("BEGIN");
		$result=mysql_query($sql,$conex);
		if ($accion && $result) {
			$result = mysql_insert_id();
		}
		if(!$result){
			$error=1;
		}
		if($error==1){
			mysql_query("ROLLBACK");
			return false;
		}
		 else{
			mysql_query("COMMIT");
			return $result;
		}
		
	}

}

?>