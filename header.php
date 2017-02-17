<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PhotoCloud</title>
<link rel="icon" href="images/icono.png"> 
<link rel="stylesheet" href="css/style.css" type="text/css" />
<link rel="stylesheet" href="css/popUp.css" type="text/css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/login.js"></script>
<script type="text/javascript" src="js/registro.js"></script>
<script type="text/javascript" src="js/js_axaj.js"></script>
<script type="text/javascript" src="js/popUp.js"></script>
<script type="text/javascript" src="js/visitasInvitado.js"></script>
<script type="text/javascript" src="js/visitasSocio.js"></script>

	<script type="text/javascript" src="fancybox/jquery.fancybox-1.3.0.pack.js"></script>
    <link rel="stylesheet" type="text/css" href="fancybox/jquery.fancybox-1.3.0.css" media="screen" /> 

	<script type="text/javascript"> 
		$(document).ready(function() {
			$("a.fancybox").fancybox({
				'titleShow'     : false,
				'transitionIn'	: 'elastic',
				'transitionOut'	: 'elastic'
			});
		});
	</script> 
    

<!-- Begin DropDown -->
      
<script type="text/javascript">
$(function(){
   $("ul.dropdown li").hover(function(){
        $(this).addClass("hover");
        $('ul:first',this).css('visibility', 'visible');
    
    }, function(){
   $(this).removeClass("hover");
   $('ul:first',this).css('visibility', 'hidden');
});
$("ul.dropdown li ul li:has(ul)").find("a:first").append(" &raquo; ");
});
</script>


</head>
<body>
	<a href="index.php"><div id="header"></div></a>