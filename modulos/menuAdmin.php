<?php
class menuAdmin{
	
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
		echo '<li><a href="index.php?action=usuarios">Usuarios</a>&nbsp;</li>';
		echo '<li><a href="index.php?action=mostrarAlbumes">Albumes Accesibles</a>&nbsp;</li>';
		echo '<li><a href="logout.php">Desconectarse</a></li>';
		echo '</ul>';
		}
		
		function footer(){
		echo '|| <a href="index.php?action=usuarios">Usuarios</a>&nbsp;';
		echo '|| <a href="index.php?action=mostrarAlbumes">Albumes Accesibles</a>&nbsp;';
		echo '|| <a href="logout.php">Desconectarse</a>';
		echo "</br></br>";	
		}
	
	/*
	 * USUARIOS
	 */
			
		function cambiarEstadoUsuario($email,$estado){
			if (isset($email) && isset($estado)){
				$this->accesManagerDB->cambiarEstadoUsuario($email, $estado);
				header('Location: index.php?action=usuarios');
			}
		}
		
		function darDeAlta(){
		
		//PAGINACION
		if(!isset($_GET['pag']))
			$pag = 1;
		else
			$pag = $_GET['pag'];
		$registrosPagina = 10; //Numero de resultados por página
		if($pag == 1)
			$listaInicio = 0;
		else
			$listaInicio = $registrosPagina * ($pag - 1);
			
			
		$result= $this->accesManagerDB->usuariosPorPagina('disabled',$listaInicio,$registrosPagina);
		echo '<table border="0">';
		while($row = mysqli_fetch_array($result)){
			echo '<tr>';
			echo '<td>'.$row['Email'].'</td>';
			echo '<td><a href="index.php?codigo='.$row['ID'].'&estado=enabled"> [Dar de alta]</a></td>';//Activa la funcion cambiarEstadoUsuario($email,$estado)
			echo '</tr>';		
		}
			echo '</table>';	
			
		//PAGINACION	
		$totalRegistros = $this->accesManagerDB->totalUsuarios('disabled');
		$totalPaginas = ceil($totalRegistros / $registrosPagina);
		for ($i = 1; $i <= $totalPaginas; $i++)
			echo " |<strong><a href='index.php?action=usuarios&pag=$i'>$i</a></strong>|";
	}
	
	function darDeBaja(){
		
		//PAGINACION
		if(!isset($_GET['pagi']))
			$pag = 1;
		else
			$pag = $_GET['pagi'];
		$registrosPagina = 10; //Numero de resultados por página
		if($pag == 1)
			$listaInicio = 0;
		else
			$listaInicio = $registrosPagina * ($pag - 1);
			
			
		$result= $this->accesManagerDB->usuariosPorPagina('enabled',$listaInicio,$registrosPagina);
		echo '<table border="0">';
		while($row = mysqli_fetch_array($result)){
			echo '<tr>';
			echo '<td>'.$row['Email'].'</td>';
			echo '<td><a href="index.php?codigo='.$row['ID'].'&estado=disabled"> [Dar de baja]</a></td>';//Activa la funcion cambiarEstadoUsuario($email,$estado)
			echo '</tr>';		
		}
			echo '</table>';	
			
		//PAGINACION	
		$totalRegistros = $this->accesManagerDB->totalUsuarios('enabled');
		$totalPaginas = ceil($totalRegistros / $registrosPagina);
		for ($i = 1; $i <= $totalPaginas; $i++)
			echo " |<strong><a href='index.php?action=usuarios&pagi=$i'>$i</a></strong>|";
	}
	
	/*
	 * ALBUMES
	 */

	function mostrarAlbumes(){
		
		echo "<h3>ALBUMES ACCESIBLES</h3><br/>";
		echo '<div id="gallery"><ul>'; //gallery
		$result= $this->accesManagerDB->albumes();
		while($row = mysqli_fetch_array($result)){
				
			echo "<li>";
			echo '<a href="index.php?codigo='.$row['Usuario'].'&album='.$row['ID'].'&action=mostrarAlbumes"><image src="images/album.png" width="170" height="170"/></a>';
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
	
		
	function borrarAlbum($album){
		$this->accesManagerDB->deleteAlbum($album);
		header('Location: index.php');
	}
	
	/*
	 * FOTOS
	 */
	
	function mostrarFotos($album,$email){
		

		$result= $this->accesManagerDB->fotosAlbum($album,$email);
		echo '<h2>Album :: '.$this->accesManagerDB->getEtiquetaAlbum($album).'</h2></br>';
		echo '<div id="gallery"><ul>'; //gallery
		while($row = mysqli_fetch_array($result)){
			echo "<li>";
			echo '<a src="data:image/jpeg;base64,'.base64_encode($row["Imagen"]).'" title="'.$row['Etiqueta'].' " class="fancybox" rel="group"><img src="data:image/jpeg;base64,'.base64_encode($row["Imagen"]).'" width="170" height="170"/></a>';
			echo '<center>'.$row['Etiqueta'].'</center>';
			echo "</br>";
			echo "<form method='post' action='index.php' enctype='multipart/form-data'>";
			echo "<input type='hidden' name ='foto' value='".$row['ID']."'/>";
			echo "<input type='submit' name ='borrarFoto' value='Borrar'/>";
			echo "</form>";
			echo "</li>";			
		}
		echo '</url></div>'; //close gallery
		echo "</br></br>";	

	}

	function borrarFoto($foto){
		$this->accesManagerDB->deleteFoto($foto);
		header('Location: index.php');
	}
	
	/*
	 * REPORTES
	 */
	 
	function mostrarReportes(){
			
			$AccesManagerDB = new AccesManagerDB;
			
			echo "<h3>Reportes:</h3><br/>";
			echo '<div id="gallery"><ul>'; //gallery
			$result= $this->accesManagerDB->getReportes();
			while($row = mysqli_fetch_array($result)){
				echo "<li>";
				if (isset($row['Album'])){
					echo '<a href="index.php?codigo='.$row['Reportado'].'&album='.$row['Album'].'"><image src="images/album.png" width="170" height="170"/></a>';
					echo '<center>'.$this->accesManagerDB->getEtiquetaAlbum($row['Album']).'</center>';
					echo "</br>";
					echo "<form method='post' action='' enctype='multipart/form-data'>";
					echo "<input type='hidden' name ='album' value='".$row['Album']."'/>";
					echo "<input type='submit' name ='borrarAlbum' value='Borrar'/>";
					echo "</form>";
				}else if (isset($row['Foto'])){
					echo '<a src="data:image/jpeg;base64,'.base64_encode($this->accesManagerDB->getFoto($row['Foto'])).'"  class="fancybox" rel="group"><img src="data:image/jpeg;base64,'.base64_encode($this->accesManagerDB->getFoto($row['Foto'])).'" width="170" height="170"/></a>';
					echo '<center>'.$this->accesManagerDB->getEtiquetaFoto($row['Foto']).'</center>';
					echo "</br>";
					echo "</br>";
					echo "<form method='post' action='' enctype='multipart/form-data'>";
					echo "<input type='hidden' name ='foto' value='".$row['Foto']."'/>";
					echo "<input type='submit' name ='borrarFoto' value='Borrar'/>";
					echo "</form>";
				}
				echo "</li>";	
			}	
		echo '</ul></div>'; //close gallery
		echo "</br></br>";
		}

	
}

/*
 * BODY
 */
 
 
if (isset($_SESSION['Usuario']) && $_COOKIE['Rango']==1){ //Si existe la sesion Usuario y la cookie de administrador

//Generamos objetod de clase
$menuAdmin = new menuAdmin;

$menuAdmin->cabecera();

	/*
	 * ACCIONES
	 */
if (@$_REQUEST['borrarAlbum']){
	$menuAdmin->borrarAlbum(@$_REQUEST['album']);
}
if (@$_REQUEST['borrarFoto']){
	$menuAdmin->borrarFoto(@$_REQUEST['foto']);
}
if (@$_REQUEST['action'] == "usuarios"){
	echo "<h3>USUARIOS DADOS DE BAJA</h3><br/>";
	$menuAdmin->darDeAlta();
	echo "</br></br>";	
	echo "<h3>USUARIOS DADOS DE ALTA</h3><br/>";
	$menuAdmin->darDeBaja();
	echo "</br></br>";	
}
if(isset($_REQUEST['album']) && isset($_REQUEST['codigo'])){
	$menuAdmin->mostrarFotos(@$_GET['album'], @$_GET['codigo']);
}
if (@$_REQUEST['action'] == "mostrarAlbumes"){
	$menuAdmin->mostrarAlbumes();
}
if(isset($_REQUEST['estado'])&& isset($_REQUEST['codigo'])){
$menuAdmin->cambiarEstadoUsuario(@$_GET['codigo'], @$_GET['estado']);
}

	/*
	 * FIN ACCIONES
	 */
$menuAdmin->mostrarReportes();
$menuAdmin->footer();
 } ?>