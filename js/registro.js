// JavaScript Document

 
var exprEmail = /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/;
var exprPassword = /^[a-zA-Z0-9!@#\$%\^&\*\?_~\/]{8,20}$/;
var exprNombre = /^[a-z]{3,15}$/i;
var exprApellidos = /^[a-z]{3,15}$/i;  //Añadir espacios

$(document).ready(function() {
	

		$('#r_Nombre').change(function(){
		validar_nombre();
	});
	
		$('#r_Apellido1').change(function(){
		validar_apellido1();
	});
	

		$('#r_Correo').change(function(){
		validar_email();
	});

		$('#r_Password').change(function(){
		validar_password();
		passwords_iguales();
	});
	
		$('#r_RepetirPassword').change(function(){
		passwords_iguales();
	});
	
		$('#insertar_Captcha').change(function(){
		captchas_iguales();
	});
	

	$('#registroEnviar').click(function(){
		
		no_error = validar_nombre() && validar_apellido1() && validar_email() && validar_password() && passwords_iguales() && captchas_iguales();
		if (no_error) {
			$.ajax({
				type: 'POST',
				url: 'modulos/procesarRegistro.php',
				data: $('#registroForm').serialize(),
				dataType: 'json',
				success: function (data) {
					$('#okRegistro').fadeIn();
					$('#okRegistro').html(data.msg);
					if(data.ok == 'ok')
					{	
						$("#registroEnviar").fadeOut();
						$("#carga").fadeIn();
						$('#okRegistro').html('Registrado correctamente');
						setTimeout(function () {
  						location.href = "index.php";
						}, 3 * 1000); // en 3 segundos será redireccionado
	
					}	
					return false;
				},
				error: function (data) {
					$('#okRegistro').fadeIn();
					$('#okRegistro').html("Hay un error:"+error.statusText);
					return false;
				}
			});
    
		} else {
			$('#okRegistro').fadeIn();
			$('#okRegistro').html('Campos incorrectos');
		}	
	});
	
});
	/* REGISTER FUNCTIONS */
	
	function validar_nombre(){
		var nombre = $("#r_Nombre").val(); // asigna a la variable nombre el valor que tiene la id nombre
		if(!exprNombre.test(nombre)){
			$("#mensaje1").fadeIn();
			return false; // evita que se manden los datos
		}else{
			$("#mensaje1").fadeOut();
			return true;
		}
	}
	
		function validar_apellido1(){
		var apellido1 = $("#r_Apellido1").val();
		if(!exprApellidos.test(apellido1)){
			$("#mensaje2").fadeIn();
			return false; 
		}else{
			$("#mensaje2").fadeOut();
			return true;
		}
	}
	
		
	function validar_email(){
		var correo = $("#r_Correo").val();
		if(!exprEmail.test(correo)){
			$("#mensaje3").fadeIn();
			return false;
		}
		else{
			$("#mensaje3").fadeOut();
			return true;
		}
	}
				
		function validar_password(){
		var password = $("#r_Password").val();
		if(!exprPassword.test(password)){
			$("#mensaje4").fadeIn();
			return false;
		}
		else{
			$("#mensaje4").fadeOut();
			return true;
		}
	}
		
	function passwords_iguales(){
		var password = $("#r_Password").val();
		var repetirPassword = $("#r_RepetirPassword").val();
		if(repetirPassword != password){
			$("#mensaje5").fadeIn();
			return false;
		}else{
			$("#mensaje5").fadeOut();
			return true;
		}
	}
	
	function captchas_iguales(){
		var insertarCaptcha = $("#insertar_Captcha").val();
		var Captcha = $("#r_Captcha").val();
		if(insertarCaptcha != Captcha){
			$("#mensaje6").fadeIn();
			return false;
		}else{
			$("#mensaje6").fadeOut();
			return true;
		}
	}