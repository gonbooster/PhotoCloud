<?php 

class menuSocio{
	
	private $accesManagerDB;
	
	/*
	 * CONSTRUCTOR
	 */
	 
	public function __construct(){
		
        $this->accesManagerDB= new  AccesManagerDB(); //Iniciamos el objeto AccesManager que mps de acceso a las funciones de consulta mysql
  	}
	
	/*
	 * MENU
	 */
	 
	function cabecera(){
		
		echo '<ul class="dropdown">';
		echo '<li><a href="index.php?action=crearAlbum">Crear Album</a>&nbsp;</li>';
		echo '<li><a href="index.php?action=subirFoto">Subir Foto</a>&nbsp;</li>';
		echo '<li><a href="index.php?action=cambiarPrivacidadAlbum">Cambiar Privacidad de Album</a>&nbsp;</li>';
		echo '<li><a href="index.php?action=mostrarAlbumesAccesibles">Albumes Accesibles</a>&nbsp;</li>';
		echo '<li><a href="logout.php">Desconectarse</a></li>';
		echo '</ul>';
	}
	
	function footer(){
		
		echo '<a href="index.php?action=crearAlbum">Crear Album</a>&nbsp;';
		echo '|| <a href="index.php?action=subirFoto">Subir Foto</a>&nbsp;';
		echo '|| <a href="index.php?action=cambiarPrivacidadAlbum">Cambiar Privacidad de Album</a>&nbsp;';
		echo '|| <a href="index.php?action=mostrarAlbumesAccesibles">Albumes Accesibles</a>&nbsp;';
		echo '|| <a href="logout.php">Desconectarse</a>';
		echo "</br></br>";
	}
	
	/*
	 * USUARIO
	 */
	function mostrarDatosSocio($Usuario){
	
		echo 'Espacio disponible: '.round($this->accesManagerDB->mostrarEspacioUsuario($Usuario)/1024,2). ' MB';
		echo "</br></br>";	
	}

	/*
	 * ALBUMES
	 */
	function mostrarAlbumes($Usuario){
		
		echo "<h3>MIS ALBUMES</h3><br/>";
		echo '<div id="gallery"><ul>'; //gallery
		$result= $this->accesManagerDB->albumesSocio($Usuario);
		while($row = mysqli_fetch_array($result)){
	
			echo "<li>";
			echo '<a href="index.php?codigo='.$row['Usuario'].'&album='.$row['ID'].'"><image src="images/album.png" width="170" height="170"/></a>'; //Accede al album clicado
			echo '<center>'.$row['Etiqueta'].'</center>';
			echo "</br>";
			echo "<form method='post' action='' enctype='multipart/form-data'>";
			echo "<input type='hidden' name ='album' value='".$row['ID']."'/>";
			echo "<input type='submit' name ='borrarAlbum' value='Borrar'/>";
			echo "</form>";
			echo "</li>";
		}	
		echo '</ul></div>'; //close gallery
		echo "</br></br>";	
	}
	
	function mostrarAlbunesAccesibles($id){

		echo "<h3>ALBUMES ACCESIBLES</h3><br/>";
		echo '<div id="gallery"><ul>'; //gallery
		$result= $this->accesManagerDB->albumesAccesibles($id);
		while($row = mysqli_fetch_array($result)){
	
			echo "<li>";
			echo '<a href="index.php?codigo='.$row['Usuario'].'&album='.$row['ID'].'&action=mostrarAlbumesAccesibles"><image src="images/album.png" width="170" height="170"/></a>'; //Accede al album clicado
			echo '<center>'.$row['Etiqueta'].'</center>';
			echo "</br>";
			echo "<form method='post' action='' enctype='multipart/form-data'>";
			echo "<input type='hidden' name ='album' value='".$row['ID']."'/>";
			echo "<input type='hidden' name ='reportador' value='".$_SESSION['Usuario']."'/>";
			echo "<input type='hidden' name ='reportado' value='".$row['Usuario']."'/>";
			echo "<input type='submit' name ='reportarAlbum' value='Reportar'/>"; //Como no es album del usuario solo podr� reportar
			echo "</form>";
			echo "</li>";
		}	
		echo '</ul></div>'; //close gallery
		echo "</br></br>";	
	}
	
	function crearAlbum($usuario, $etiquetaAlbum) {
		
		if($this->accesManagerDB->existeAlbum($usuario,$etiquetaAlbum))
			$result = "Album ya existente.";
		else{
			$this->accesManagerDB->crearAlbum($usuario,$etiquetaAlbum);
			$result = "Insercion de album realizada correctamente.";
		}
		return $result;
	}
		
	function selectAlbumes($usuario){//Genera desplegable de los albumes (solo la etiqueta) del usuario
	
	  $devolver = "<select name='album'>";
	  $result= $this->accesManagerDB->albumesSocio($usuario);
	   while($row = mysqli_fetch_array($result))
	      $devolver .= "<option value='".$row["ID"]."'>".$row["Etiqueta"]."</option>";
	  $devolver .= "</select>";
	  return $devolver;
	}
	
	function cambiarPrivacidadAlbum($usuario,$album,$privacidad){
		$this->accesManagerDB->cambiarPrivacidadAlbum($usuario,$album,$privacidad);		
	}
	
	function borrarAlbum($album){
		$this->accesManagerDB->deleteAlbum($album);
		header('Location: index.php');
	}
	
	/*
	 * FOTOS
	 */
	 
	function mostrarFotos($album,$Usuario){
		
		echo '<h2>Album :: '.$this->accesManagerDB->getEtiquetaAlbum($album).'</h2></br>';
		echo '<div id="gallery"><ul>'; //gallery
		$result= $this->accesManagerDB->fotosAlbum($album,$Usuario);
		while($row = mysqli_fetch_array($result)){
			echo "<li>";
			if($_SESSION['Usuario']==$row['Usuario']){
				echo '<a src="data:image/jpeg;base64,'.base64_encode($row["Imagen"]).'" class="fancybox" rel="group"><img src="data:image/jpeg;base64,'.base64_encode($row["Imagen"]).'" width="170" height="170"/></a>';
			}else {
				echo '<a onclick="visitaSocio('.$row['ID'].')" src="data:image/jpeg;base64,'.base64_encode($row["Imagen"]).'" class="fancybox" rel="group"><img src="data:image/jpeg;base64,'.base64_encode($row["Imagen"]).'" width="170" height="170"/></a>';
			}
			echo '<center>'.$row['Etiqueta'].'</center>';
			echo "</br>";
			echo "<form method='post' action='' enctype='multipart/form-data'>";
			echo "<input type='hidden' name ='foto' value='".$row['ID']."'/>";
			if ($_SESSION['Usuario']==$row['Usuario']){//Si la foto corresponde a el usuario logeado
				echo '<table><tr><td>Visitas de invitados:</td><td align="right"><div id="'.$row['ID'].'">'.$row['VisitasInvitados'].'</div></td></tr><tr><td>Visitas de socios:</td><td align="right">'.$row['VisitasSocios'].'</td></tr></table>';
				echo "<input type='submit' name ='borrarFoto' value='Borrar'/>";
			}else{
			echo "<input type='hidden' name ='reportador' value='".$_SESSION['Usuario']."'/>";
			echo "<input type='hidden' name ='reportado' value='".$row['Usuario']."'/>";
			echo "<input type='submit' name ='reportarFoto' value='Reportar'/>";
			}
			echo "</form>";
			echo "</li>";			
		}
		echo '</url></div>'; //gallery

	}
	
	function subirFoto($usuario, $album, $etiqueta, $field_name){

		if (strlen ($etiqueta) < 3)
			return $msg = "Etiquea vacia (Obligatorio 3 caracteres minimo).";
		if($this->accesManagerDB->existeFoto($album,$usuario,$etiqueta))
			return $msg='Ya existe una esta etiqueta para el album indicado';
		else{
				$file = $_FILES[$field_name]['tmp_name'];
				$size = round($_FILES[$field_name]['size']/1024 * 100) /100;
				if(($size > 0) && $size < 1024){//la imagen a insertar no debe superar 1 mb
					$imagen = addslashes(file_get_contents($file));
					if($this->accesManagerDB->mostrarEspacioUsuario($usuario) > $size){//si el espacio disponible es mayor que la imagen...
					$this->accesManagerDB->subirFoto($album,$usuario,$etiqueta,$imagen,$size);
					} else
						return $msg = "Limite agotado.";
				}else
					return $msg = "Imagen invalida.";
		}
		return $msg="Imagen creada exitosamente";
	}

	function borrarFoto($foto){
		$this->accesManagerDB->deleteFoto($foto);
		header('Location: index.php');
	}
	
	/*
	 * REPORTES
	 */
	 
	function reportarAlbum($usuario,$reportado,$album){
	 	$this->accesManagerDB->reportAlbum($usuario,$reportado,$album);
		header('Location: index.php?action=mostrarAlbumesAccesibles');
	 }
	
	function reportarFoto($usuario,$reportado,$foto){
	 	$this->accesManagerDB->reportFoto($usuario,$reportado,$foto);
		header('Location: index.php?action=mostrarAlbumesAccesibles');
	 }
}

/*
 * BODY
 */
 

if (isset($_SESSION['Usuario']) && $_COOKIE['Rango']==0){ //Si existe la sesion Usuario y la cookie de socio

//Generamos objetod de clase
$menuSocio = new menuSocio();


$menuSocio->cabecera();//menu Socio
$menuSocio->mostrarDatosSocio($_SESSION['Usuario']);

	/*
	 * ACCIONES
	 */
	 
if (@$_REQUEST['borrarAlbum']){
	$menuSocio->borrarAlbum(@$_REQUEST['album']);
}
if (@$_REQUEST['borrarFoto']){
	$menuSocio->borrarFoto(@$_REQUEST['foto']);
}
if (@$_REQUEST['reportarAlbum']){
	$menuSocio->reportarAlbum($_SESSION['Usuario'],$_REQUEST['reportado'],$_REQUEST['album']);
}
if (@$_REQUEST['reportarFoto']){
	$menuSocio->reportarFoto($_SESSION['Usuario'],$_REQUEST['reportado'],$_REQUEST['foto']);
}	
if (@$_REQUEST['action'] == "crearAlbum"){
	echo "<h3>CREAR ALBUM</h3><br/>";
	echo "<form method='post' action='index.php' enctype='multipart/form-data'>";
	echo "Nombre del album: <input type='text' name='etiquetaAlbum' id='etiquetaAlbum'/><br/>";
	echo "<input type='submit' name ='CrearAlbum' value='Crear'/>";
	echo "</form>";
	echo "</br></br>";	
}
if (isset($_REQUEST['CrearAlbum'])){
		echo $menuSocio->crearAlbum($_SESSION['Usuario'], $_REQUEST['etiquetaAlbum']);
}		
if (@$_REQUEST['action'] == "subirFoto"){
	echo "<h3>INSERTAR FOTO</h3><br/>";
	echo "<form method='post' action='' enctype='multipart/form-data'>";
	echo "Seleccionar foto: <input type='file' name='imagen' id='imagen'/><br/>";
	echo "Nombre de la foto: <input type='text' name='etiqueta' id='etiqueta'/><br/>";
	echo "Album contenedor: ";
	echo $menuSocio->selectAlbumes($_SESSION['Usuario']);
	echo "<input type='submit' name ='subirFoto' value='Subir'/>";
	echo "</form>";
	echo "</br></br>";	
}
if (isset($_REQUEST['subirFoto'])){
	echo $menuSocio->subirFoto($_SESSION['Usuario'], $_REQUEST['album'],$_REQUEST['etiqueta'],"imagen");
}		
if (@$_REQUEST['action'] == "cambiarPrivacidadAlbum"){
	echo "<h3>CAMBIAR PRIVACIDAD DEL ALBUM</h3><br/>";
	echo "<form method='post' action='' enctype='multipart/form-data'>";
	echo "Album: ";
	echo $menuSocio->selectAlbumes($_SESSION['Usuario']);
	echo "</br>";
	echo "Privacidad a asignar: ";
	echo "<select name='privacidad'>
		<option value='private'>Private</option>
		<option value='protected'>Protected</option>
		<option value='public'>Public</option>
	</select>";
	echo "</br>";
	echo "<input type='submit' name ='cambiarPrivacidadAlbum' value='Cambiar'/>";
	echo "</form>";
	echo "</br></br>";	
}
if (isset($_REQUEST['cambiarPrivacidadAlbum'])){
	echo $menuSocio->cambiarPrivacidadAlbum($_SESSION['Usuario'], $_REQUEST['album'],$_REQUEST['privacidad']);
}
if(isset($_REQUEST['album']) && isset($_REQUEST['codigo'])){
	$menuSocio->mostrarFotos(@$_GET['album'], @$_GET['codigo']);
}
if (@$_REQUEST['action'] == "mostrarAlbumesAccesibles"){
	$menuSocio->mostrarAlbunesAccesibles($_SESSION['Usuario']);
}
	
	/*
	 * FIN ACCIONES
	 */
	

		$menuSocio->mostrarAlbumes($_SESSION['Usuario']);
		$menuSocio->footer();
}
?>