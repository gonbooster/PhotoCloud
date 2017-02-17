<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'] .'/PhotoCloud/businessLogic/accesManagerDB.php');

class procesarLogin {

	private $accesManagerDB;
	
	/*
	 * CONSTRUCTOR
	 */
	 
	public function __construct(){
		
        $this->accesManagerDB= new  AccesManagerDB(); //Iniciamos el objeto AccesManager que mps de acceso a las funciones de consulta mysql

  	}
	
	function formValidate($email,$password) {
		
		//Establish values that will be returned via ajax
		$return = array();
		$return['ok'] = '';
		$return['msg'] = '';

        //Body
		if ($this->accesManagerDB->existeUsuarioActivo($email,$password)){
			$_SESSION['Usuario'] = $this->accesManagerDB->getID($email);
			$rango=0;
			if ($this->accesManagerDB->esAdmin($email))
				$rango=1;
			setcookie('Rango', $rango, time() + (86400 /5), "/"); // 86400 = 1 day	//Generamos una cookie que almacene el rango del cliente
			$return['ok'] = 'ok';
			$return['msg'] = 'Usuario logeado correctamente';
		}
		else
			$return['msg'] = 'Imposible logearse: usuario inexistente o cuenta bloqueada';
		
		//Return json encoded results
		return json_encode($return);
	}
	
}

//Put form elements into post variables (this is where you would sanitize your data)
$email = htmlentities(@$_REQUEST['l_correo']);
$password = htmlentities(md5(@$_REQUEST['l_password']));

//crear objeto procesarlogin
$procesarLogin = new procesarLogin();
		
echo $procesarLogin->formValidate($email,$password);