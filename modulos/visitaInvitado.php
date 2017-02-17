<?php
include_once($_SERVER['DOCUMENT_ROOT'] .'/PhotoCloud/businessLogic/accesManagerDB.php');
$id = @$_REQUEST['id'];

class visitasInvitado{
	private $accesManagerDB;
	
	public function __construct(){
		$this->accesManagerDB = new AccesManagerDB;
	}
	
	function aumentarVisita($id){
		$this->accesManagerDB->aumentarVisitasInvitados($id);
	}
}

$visitas = new visitasInvitado();
$visitas->aumentarVisita($id);
?>