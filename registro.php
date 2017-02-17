	<div id="register-box" class="register-popup">
	<fieldset class="textbox">
<form class="signin" id="registroForm" action="" method="POST">
		<div id="okRegistro" class="error"></div>
<table border="0">
	<th>Registro</th>
	  <tr>
       <td>Nombre: (*)<input type="text" name="r_Nombre" id="r_Nombre"/></td>
    <td><div id="mensaje1" class="error">*Por favor, introduzca su nombre</div></td>
  </tr>
    <tr>
       <td>Apellido1: (*)<input type="text" name="r_Apellido1" id="r_Apellido1"/></td>
    <td><div id="mensaje2" class="error">*Por favor, introduzca su primer apellido</div></td>
  </tr>
    <tr>
    <td colspan="2">Apellido2:<input type="text" name="r_Apellido2" id="r_Apellido2"/></td>
  </tr>
  <tr>
    <td>Correo: (*)<input type="email" name="r_Correo" id="r_Correo"/></td>
    <td><div id="mensaje3" class="error">*Por favor, introduzca su email</div></td>
  </tr>
  <tr>
    <td>Contraseña: (*)<input type="password" name="r_Password" id="r_Password"/></td>
    <td><div id="mensaje4" class="error">*Por favor, introduzca una contraseña (8-20 carácteres)</div></td>
  </tr>
  <tr>
    <td>Repetir contraseña: (*)<input type="password" name="r_RepetirPassword" id="r_RepetirPassword"/></td>
    <td><div id="mensaje5" class="error">*Las contraseñas no coinciden</div></td>
  </tr>
    <tr>
    <td colspan="2"><button id="registroEnviar" name="registroEnviar" type="button">Registrarse</button></div></td>
  </tr>
</table>
     <div id="carga">
  <img src="images/loading.gif" />
</div>
</form>
</fieldset>
</div>
