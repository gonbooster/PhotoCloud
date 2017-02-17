<?php 
include_once($_SERVER['DOCUMENT_ROOT'] .'/PhotoCloud/dataAcces/DBManager.php');

class AccesManagerDB{

	private $DBManager;
	
	/*
	 * CONSTRUCTOR
	 */
	 
	public function __construct(){
		
        $this->DBManager= new  DBManager; //Iniciamos el objeto DBManager que mps de acceso a las funciones de consulta mysql
  	}
	
/*
 * USUARIOS
 */
	//insertar un socio en la bd
	function insertarSocio($email,$nombre,$apellido1,$apellido2,$password,$fecha_ingreso){
		$DBManager = new DBManager;
		
		$con= $this->DBManager->conectarDB();
		mysqli_query($con,"INSERT INTO usuario (Email,Nombre,Apellido1,Apellido2,Password,Fecha) VALUES ('$email','$nombre','$apellido1','$apellido2','$password','$fecha_ingreso')") or die ("Error: ".mysqli_error($con));
		$acces = new AccesManagerDB();
		$id= $acces->getID($email);
		mysqli_query($con,"INSERT INTO album (Etiqueta,Usuario,Fecha) VALUES ('Mis Fotos Subidas', '$id', '$fecha_ingreso')") or die ("Error: ".mysqli_error($con));
		$this->DBManager->cerrarDB($con);
	}
	
	//Dado un email y un password identificar si existen
	function existeUsuarioActivo($email, $password){
		$DBManager = new DBManager;
		
		$existe=true;		
		$con= $this->DBManager->conectarDB();
		$result = mysqli_query($con,"SELECT * FROM usuario WHERE Password = '$password' AND Email = '$email' AND Estado= 'enabled'") or die ("Error: ".mysqli_error($con));
				if(mysqli_num_rows($result) == 0)
			$existe= false;	
		$this->DBManager->cerrarDB($con);
		
		return $existe;
	}
	
	//Dado un email identificar si existe
	function existeEmail($email){
		$DBManager = new DBManager;
		
		$existe=true;		
		$con= $this->DBManager->conectarDB();
		$result = mysqli_query($con,"SELECT * FROM usuario WHERE Email = '$email'") or die ("Error: ".mysqli_error($con));
		if(mysqli_num_rows($result) == 0)
			$existe= false;	
		$this->DBManager->cerrarDB($con);
		
		return $existe;
	}
		//Dado un email identificar si el usuario es administrador
	function esAdmin($email){
		$DBManager = new DBManager;
		
		$existe=true;		
		$con= $this->DBManager->conectarDB();
		$result = mysqli_query($con,"SELECT * FROM usuario WHERE Rango = '1' AND Email = '$email' AND Estado= 'enabled'") or die ("Error: ".mysqli_error($con));
				if(mysqli_num_rows($result) == 0)
			$existe= false;	
		$this->DBManager->cerrarDB($con);
		
		return $existe;
	}
		//Dado un email obtener su identificador
	function getID($email){
		$DBManager = new DBManager;
		
		$con= $this->DBManager->conectarDB();
		$result = mysqli_query($con,"SELECT * FROM usuario WHERE Email = '$email'") or die ("Error: ".mysqli_error($con));
		while($row = mysqli_fetch_array($result))
			$id=$row['ID'];
		$this->DBManager->cerrarDB($con);
		
		return $id;
	}
	
	
	//cambia el estado de usuario
	function cambiarEstadoUsuario($id,$estado){
		$DBManager = new DBManager;
		
		$con= $this->DBManager->conectarDB();
		mysqli_query($con,"UPDATE usuario set Estado='".$estado."' WHERE ID = '$id'") or die ("Error: ".mysqli_error($con));
		$this->DBManager->cerrarDB($con);
	}
		
		
		//mostrar el espacio del usuario
	function mostrarEspacioUsuario($id){
		$DBManager = new DBManager;

		$con= $this->DBManager->conectarDB();
		$result = mysqli_query($con,"SELECT * FROM usuario WHERE ID = '$id'") or die ("Error: ".mysqli_error($con));
		while($row = mysqli_fetch_array($result))
			$cuenta=$row['TamanoRestante'];
		$this->DBManager->cerrarDB($con);
		
		return $cuenta;
	}
	
	//Devuelve el total de usuarios activados o desactivados según el valor introducido
	function totalUsuarios($estado){
		$DBManager = new DBManager;
		
		$con= $this->DBManager->conectarDB();
		$result= mysqli_query($con,"select * FROM usuario WHERE Estado ='".$estado."'") or die ("Error: ".mysqli_error($con));
		$this->DBManager->cerrarDB($con);
		
		return mysqli_num_rows($result);
	}
	
	//Devuelve el total de usuarios activados o desactivados según el valor introducido (limitación de x resultados por página)
	function usuariosPorPagina($estado,$listaInicio,$registrosPagina){
		$DBManager = new DBManager;
		
		$con= $this->DBManager->conectarDB();
		$result= mysqli_query($con,"select * FROM usuario WHERE Estado ='".$estado."' ORDER BY Fecha DESC LIMIT $listaInicio, $registrosPagina") or die ("Error: ".mysqli_error($con));
		$this->DBManager->cerrarDB($con);
		
		return $result;
	}
	
/*
 * ALBUMES
 */
 
 		//Dado un ID obtener su Etiqueta
	function getEtiquetaAlbum($id){
		$DBManager = new DBManager;
		
		$con= $this->DBManager->conectarDB();
		$result = mysqli_query($con,"SELECT * FROM album WHERE ID = '$id'") or die ("Error: ".mysqli_error($con));
		while($row = mysqli_fetch_array($result))
			$id=$row['Etiqueta'];
		$this->DBManager->cerrarDB($con);
		
		return $id;
	}
	//Devuelve el total de albumes del socio introducido
	function albumesSocio($id){
		$DBManager = new DBManager;
		
		$con= $this->DBManager->conectarDB();
		$result= mysqli_query($con,"select * FROM album WHERE Usuario ='".$id."'  ORDER BY Fecha DESC") or die ("Error: ".mysqli_error($con));
		$this->DBManager->cerrarDB($con);
		
		return $result;
	}
	
		//Devuelve el total de albumes protejidos o publicos menos los del socio indicado
	function albumesAccesibles($id){
		$DBManager = new DBManager;
		
		$con= $this->DBManager->conectarDB();
		$result= mysqli_query($con,"select * FROM album WHERE Usuario !='".$id."' AND Privacidad !='Private' ORDER BY Fecha DESC") or die ("Error: ".mysqli_error($con));
		$this->DBManager->cerrarDB($con);
		
		return $result;
	}
	
	//Devuelve todos los albumes
	function albumes(){
		$DBManager = new DBManager;
		
		$con= $this->DBManager->conectarDB();
		$result= mysqli_query($con,"select * FROM album ORDER BY Fecha DESC") or die ("Error: ".mysqli_error($con));
		$this->DBManager->cerrarDB($con);
		
		return $result;
	}
	
		//Devuelve el total de albumes segun su privacidad
	function albumesPrivacidad($privacidad){
		$DBManager = new DBManager;
		
		$con= $this->DBManager->conectarDB();
		$result= mysqli_query($con,"select * FROM album WHERE Privacidad ='".$privacidad."' ORDER BY Fecha DESC") or die ("Error: ".mysqli_error($con));
		$this->DBManager->cerrarDB($con);
		
		return $result;
	}
	
	
		//cambia la privacidad del album
	function cambiarPrivacidadAlbum($usuario,$album,$privacidad){
		$DBManager = new DBManager;
		
		$con= $this->DBManager->conectarDB();
		mysqli_query($con,"UPDATE album SET Privacidad = '".$privacidad."' WHERE Usuario = '$usuario' AND ID = '$album'") or die ("Error: ".mysqli_error($con));
		$this->DBManager->cerrarDB($con);
	}
	
			//Borrar Album y sus fotos (Esto lo hace la propia db)
	function deleteAlbum($id){
		$DBManager = new DBManager;
		
		$con= $this->DBManager->conectarDB();
		mysqli_query($con,"Delete from album WHERE ID = '".$id."' and Etiqueta != 'Mis Fotos Subidas'") or die ("Error: ".mysqli_error($con));
		$this->DBManager->cerrarDB($con);
	}
	
	 	//Devuelve true si existe el album para un usuario y etiqueta dada.Sino devuelve false
	function existeAlbum($usuario,$etiqueta){
		$DBManager = new DBManager;
		
		$existe=false;
		$con= $this->DBManager->conectarDB();
		$result = mysqli_query($con, "SELECT * FROM album WHERE Etiqueta = '".$etiqueta."' and Usuario = '".$usuario."'") or mysqli_error();
		if(mysqli_num_rows($result)> 0)
			$existe=true;
		$this->DBManager->cerrarDB($con);
		return $existe;
	}
	//Crea un album
	function crearAlbum($usuario,$etiquetaAlbum){
		$DBManager = new DBManager;
		
		$con= $this->DBManager->conectarDB();
		$fecha = date("Y-m-d h:i:s", time());
		mysqli_query($con, "INSERT INTO album (Etiqueta, Usuario, Privacidad, Fecha) VALUES ('".$etiquetaAlbum."', '".$usuario."', 'private', '".$fecha."')") or mysqli_error();
		$this->DBManager->cerrarDB($con);
	}
	
/*
 * FOTOS
 */
 
  		//Dado un ID obtener su Etiqueta
	function getEtiquetaFoto($id){
		$DBManager = new DBManager;
		
		$con= $this->DBManager->conectarDB();
		$result = mysqli_query($con,"SELECT * FROM foto WHERE ID = '$id'") or die ("Error: ".mysqli_error($con));
		while($row = mysqli_fetch_array($result))
			$id=$row['Etiqueta'];
		$this->DBManager->cerrarDB($con);
		
		return $id;
	}
  	//Insetar una foto en la bd y descuenta espacio disponible al usuario
	function subirFoto($album,$usuario,$etiqueta,$imagen,$size){//el album es la id del album!!!!
		$DBManager = new DBManager;
		$con= $this->DBManager->conectarDB();
		$fecha = date("Y-m-d h:i:s", time());
		mysqli_query($con, "INSERT INTO foto (Usuario, Album, Etiqueta, Imagen, Fecha) VALUES ('".$usuario."', '".$album."', '".$etiqueta."', '".$imagen."', '".$fecha."')") or mysqli_error();
		mysqli_query($con, "UPDATE usuario SET TamanoRestante = TamanoRestante - ".$size." WHERE ID ='".$usuario."'") or mysqli_error();
		$this->DBManager->cerrarDB($con);
	}
	
 	//Devuelve true si existe la foto con esa etiqueta para un album y un usuario en concreto. Sino false.
	function existeFoto($album,$usuario,$etiqueta){
		$DBManager = new DBManager;
		
		$existe=false;
		$con= $this->DBManager->conectarDB();
		$result = mysqli_query($con, "SELECT * FROM foto WHERE Etiqueta = '".$etiqueta."' and Album = '".$album."' and Usuario = '".$usuario."'") or mysqli_error();
		if(mysqli_num_rows($result)> 0)
			$existe=true;
		$this->DBManager->cerrarDB($con);
		return $existe;
	}
 
		//Devuelve el total de fotos según el valor introducido (limitación de x resultados por página)
	function fotosAlbum($album,$usuario){
		$DBManager = new DBManager;
		
		$con= $this->DBManager->conectarDB();
		$result= mysqli_query($con,"select * FROM foto WHERE Usuario = '$usuario' AND Album = '$album' ORDER BY Fecha DESC") or die ("Error: ".mysqli_error($con));
		$this->DBManager->cerrarDB($con);
		
		return $result;
	}
	
	//Devuelve una foto dado una ID
	function getFoto($foto){
		$DBManager = new DBManager;
		
		$con= $this->DBManager->conectarDB();
		$result= mysqli_query($con,"select Imagen FROM foto WHERE ID= '$foto' ") or die ("Error: ".mysqli_error($con));
		while($row = mysqli_fetch_array($result))
			$imagen=$row['Imagen'];
		$this->DBManager->cerrarDB($con);
		
		return $imagen;
	}
	
	//Borrar foto
	function deleteFoto($id){
		$DBManager = new DBManager;
		
		$con= $this->DBManager->conectarDB();
		mysqli_query($con,"Delete from foto WHERE ID = '".$id."'") or die ("Error: ".mysqli_error($con));
		$this->DBManager->cerrarDB($con);
	}


/*
 * REPORTES
 */
 	
 	//Manda un reporte de un album
	function reportAlbum($reportador, $reportado, $album){
		$DBManager = new DBManager;
		
		$fecha = date("Y-m-d h:i:s", time());
		$con= $this->DBManager->conectarDB();
		mysqli_query($con,"INSERT INTO report (Reportador,Reportado,Album,Fecha) VALUES ('$reportador','$reportado','$album','$fecha')") or die ("Error: ".mysqli_error($con));
		$this->DBManager->cerrarDB($con);
	}
	
	//Manda un reporte de una foto
	function reportFoto($reportador, $reportado, $foto){
		$DBManager = new DBManager;
		
		$fecha = date("Y-m-d h:i:s", time());
		$con= $this->DBManager->conectarDB();
		mysqli_query($con,"INSERT INTO report (Reportador,Reportado,Foto,Fecha) VALUES ('$reportador','$reportado','$foto','$fecha')") or die ("Error: ".mysqli_error($con));
		$this->DBManager->cerrarDB($con);
	}
	
	//Obtiene los reportes (no muestra repetidos GROUP BY Reportador,Reportado,Album,Foto)
	function getReportes(){
		$DBManager = new DBManager;
		
		$con= $this->DBManager->conectarDB();
		$result=mysqli_query($con,"SELECT * FROM report  GROUP BY Reportador,Reportado,Album,Foto ORDER BY Fecha ASC") or die ("Error: ".mysqli_error($con));
		$this->DBManager->cerrarDB($con);
		return $result;
		
	}
	
/*
 * ESTADISTICAS
 */
 	//Actualiza el contador de visitas de invitados y devuelve su valor
	function aumentarVisitasInvitados($id){
		$DBManager = new DBManager;
		$con= $this->DBManager->conectarDB();
		$result=mysqli_query($con,"UPDATE foto SET VisitasInvitados = VisitasInvitados + 1 WHERE id = '".$id."'") or mysqli_error($con);
		$foto=mysqli_query($con,"SELECT * FROM foto WHERE id = '".$id."'") or mysqli_error($con);
		$id=mysqli_fetch_array($foto);
		$this->DBManager->cerrarDB($con);
		return $id['VisitasInvitados'];
	}
	
	//Actualiza el contador de visitas de socio y devuelve su valor
	function aumentarVisitasSocios($id){
		$DBManager = new DBManager;
		$con= $this->DBManager->conectarDB();
		$result=mysqli_query($con,"UPDATE foto SET VisitasSocios = VisitasSocios + 1 WHERE id = '".$id."'") or mysqli_error($con);
		$foto=mysqli_query($con,"SELECT * FROM foto WHERE id = '".$id."'") or mysqli_error($con);
		$id=mysqli_fetch_array($foto);
		$this->DBManager->cerrarDB($con);
		return $id['VisitasSocios'];
	}
	
} ?>