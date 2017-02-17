<?php 

class menuInvitado{
	
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
		echo '<li><a href="#login-box" class="login-window">Login</a></li>';		
		echo '<li><a href="#register-box" class="register-window">Registrarse</a></li>';		
		echo '</ul>';
		require_once($_SERVER['DOCUMENT_ROOT'] .'/PhotoCloud/login.php'); //Carga el login (esta oculto por defecto)		
		require_once($_SERVER['DOCUMENT_ROOT'] .'/PhotoCloud/registro.php'); //Carga el registro (esta oculto por defecto)	
	}
	
	
	/*
	 * ALBUMES
	 */
	 
	
	function mostrarAlbum(){
	
		echo "<h3>ALBUMES PUBLICOS</h3><br/>";
		echo '<div id="gallery"><ul>'; //gallery
		$result= $this->accesManagerDB->albumesPrivacidad('public');
		while($row = mysqli_fetch_array($result)){
	
			echo "<li>";
			echo '<a href="index.php?codigo='.$row['Usuario'].'&album='.$row['ID'].'"><image src="images/album.png" width="170" height="170"/></a>'; //Accede al album clicado
			echo '<center>'.$row['Etiqueta'].'</center>';
			echo "</li>";
			
		}	
		echo '</ul></div>'; //close gallery	
		echo "</br></br>";	
	}

	/*
	 * FOTOS
	 */
	 
	function mostrarFotos($album,$email){
				
		echo '<h2>Album :: '.$this->accesManagerDB->getEtiquetaAlbum($album).'</h2></br>';
		echo '<div id="gallery"><ul>'; //gallery
		$result= $this->accesManagerDB->fotosAlbum($album,$email);
		while($row = mysqli_fetch_array($result)){
			echo "<li>";
			//visitaInvitado("'.$row['ID'].'")
			echo '<a onclick="visitaInvitado('.$row['ID'].')" src="data:image/png;base64,'.base64_encode($row["Imagen"]).'" class="fancybox" rel="group"><img src="data:image/jpeg;base64,'.base64_encode($row["Imagen"]).'" width="170" height="170"/></a>';
			//$this->accesManagerDB->aumentarVisitasInvitados(46);
			echo '<center>'.$row['Etiqueta'].'</center>';
			echo "</li>";
		}
		echo '</ul></div>'; //gallery
		echo "</br></br>";

	}

}

/*
 * BODY
 */
 
if (!isset($_SESSION['Usuario'])){ //Si no existe la sesion Usuario

	
	//Generamos objetod de clase
	$menuInvitado = new menuInvitado;
	
	$menuInvitado->cabecera();
		
		if(isset($_REQUEST['album']) && isset($_REQUEST['codigo'])){
		$menuInvitado->mostrarFotos(@$_GET['album'], @$_GET['codigo']);
	}

	$menuInvitado->mostrarAlbum();
}?>