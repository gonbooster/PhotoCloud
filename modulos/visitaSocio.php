<?php
include_once($_SERVER['DOCUMENT_ROOT'] .'/PhotoCloud/businessLogic/accesManagerDB.php');
$id = @$_REQUEST['id'];

class visitasSocio{
	private $accesManagerDB;
	
	public function __construct(){
		$this->accesManagerDB = new AccesManagerDB;
	}
	
	function aumentarVisita($id){
		$this->accesManagerDB->aumentarVisitasSocios($id);
	}
}

$visitas = new visitasSocio();
$visitas->aumentarVisita($id);
?>