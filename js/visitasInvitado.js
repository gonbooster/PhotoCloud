function visitaInvitado(id){
	/*
	var XMLHttpRequestObject = new XMLHttpRequest();
	alert("Hola");
	XMLHttpRequestObject.open("GET","visitaInvitado.php?id="+id,true);
	//XMLHttpRequestObject.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	XMLHttpRequestObject.send();
	alert("Enviado");
	*/
	$.ajax({
				type: 'GET',
				url: 'modulos/visitaInvitado.php',
				data: "id="+id
				
	});

}

