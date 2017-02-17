// JavaScript Document

 
var exprEmail = /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/;
var exprPassword = /^[a-zA-Z0-9!@#\$%\^&\*\?_~\/]{8,20}$/;

$(document).ready(function() {
	

		

		$('#l_correo').change(function(){
		validar_login_email();
	});

		$('#l_password').change(function(){
		validar_login_password();
	});
	

	$('#btnLogin').click(function(){
		no_error_login = validar_login_email() && validar_login_password();
		if (no_error_login) {
			$.ajax({
				type: 'POST',
				url: 'modulos/procesarLogin.php',
				data: $('#loginForm').serialize(),
				dataType: 'json',
				success: function (data) {
					if(data.ok == 'ok')
						location.href='index.php';
	
					$('#ok').fadeIn();
					$('#ok').html(data.msg);
					return false;
				},
				error: function (data) {
					$('#ok').fadeIn();
					$('#ok').html(error.statusText);
					return false;
				}
			});
    
		} else {
			$('#ok').fadeIn();
			$('#ok').html('Campos incorrectos');
		}	
	});
	
});
	/* LOGIN FUNCTIONS */
	
	
		
	function validar_login_email(){
		var correo = $("#l_correo").val();
		if(!exprEmail.test(correo)){
			$("#msg_l_correo").fadeIn();
			return false;
		}
		else{
			$("#msg_l_correo").fadeOut();
			return true;
		}
	}
				
		function validar_login_password(){
		var password = $("#l_password").val();
		if(!exprPassword.test(password)){
			$("#msg_l_pass").fadeIn();
			return false;
		}
		else{
			$("#msg_l_pass").fadeOut();
			return true;
		}
	}