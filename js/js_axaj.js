function objetoAjax()
{
	var xmlhttp = false;
	try
	{
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	}
	catch(e)
	{
		try
		{
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		catch(E)
		{
		xmlhttp = false;
		}
	}
	if (!xmlhttp && typeof XMLHttpRequest != 'undefined')
	{
		xmlhttp = new XMLHttpRequest();
	}
	return xmlhttp;
}

function iniciarConsulta(datos)
{
	divConsulta = document.getElementById('consulta');
	ajax = objetoAjax();
	ajax.open("GET", datos);
	ajax.onreadystatechange = function()
	{
		if(ajax.readyState == 4)
		{
			divConsulta.innerHTML = ajax.responseText
		}
	}
	ajax.send(null)
}

function cursor(ev)
{
	document.getElementById(ev).style.display="inline";
	document.getElementById(ev).style.position="absolute";
	document.getElementById(ev).style.left=event.clientX+10;
	document.getElementById(ev).style.top=event.clientY;
}

function esconder(event)
{
	document.getElementById(event).style.display="none";
}