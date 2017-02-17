function visitaSocio(id){

	$.ajax({
		type: 'GET',
		url: 'modulos/visitaSocio.php',
		data: "id="+id			
	});

}
