<?php
require_once($_SERVER['DOCUMENT_ROOT'] .'/PhotoCloud/header.php'); //Contiene los metas, css, js,....
include_once($_SERVER['DOCUMENT_ROOT'] .'/PhotoCloud/businessLogic/accesManagerDB.php'); //Aceso a las funciones mysql 
require_once($_SERVER['DOCUMENT_ROOT'] .'/PhotoCloud/modulos/menuInvitado.php'); //Muestra el menu y funciones accesibles por los invitados
require_once($_SERVER['DOCUMENT_ROOT'] .'/PhotoCloud/modulos/menuSocio.php'); //Muestra el menu y funciones accesibles por los socios
require_once($_SERVER['DOCUMENT_ROOT'] .'/PhotoCloud/modulos/menuAdmin.php'); //Muestra el menu y funciones accesibles por los administradores
require_once($_SERVER['DOCUMENT_ROOT'] .'/PhotoCloud/footer.php'); //Muestra el pie de  página
?>