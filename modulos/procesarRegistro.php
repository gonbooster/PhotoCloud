<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'] .'/PhotoCloud/businessLogic/accesManagerDB.php');

class procesarRegistro {

	private $accesManagerDB;
	/*
	 * CONSTRUCTOR
	 */
	 
	public function __construct(){
		
        $this->accesManagerDB= new  AccesManagerDB(); //Iniciamos el objeto AccesManager que mps de acceso a las funciones de consulta mysql        
  	}
	
	function formValidate($nombre,$apellido1,$apellido2,$email,$password,$repetirPassword) {

		//Establish values that will be returned via ajax
		$return = array();
		$return['ok'] = '';
		$return['msg'] = '';

        //Body
		if(!$this->accesManagerDB->existeEmail($email)){
			$fecha_ingreso = date("Y-m-d h:i:s");
			$password = md5($password);
			$this->accesManagerDB->insertarSocio($email,$nombre,$apellido1,$apellido2,$password,$fecha_ingreso);
			$return['msg'] = 'Usuario registrado correctamente';
			$return['ok'] = 'ok';
		}
		else
			$return['msg'] = 'Usuario existente';
		
		//Return json encoded results
		return json_encode($return);
	}
	
}

//Put form elements into post variables (this is where you would sanitize your data)
$nombre= htmlentities(@$_REQUEST['r_Nombre']);
$apellido1= htmlentities(@$_REQUEST['r_Apellido1']);
$apellido2= htmlentities(@$_REQUEST['r_Apellido2']);
$email= htmlentities(@$_REQUEST['r_Correo']);
$password= htmlentities(@$_REQUEST['r_Password']);
$repetirPassword= htmlentities(@$_REQUEST['r_RepetirPassword']);

//creamos objeto de procesarregistro
$procesarRegistro = new procesarRegistro();

echo $procesarRegistro->formValidate($nombre,$apellido1,$apellido2,$email,$password,$repetirPassword);