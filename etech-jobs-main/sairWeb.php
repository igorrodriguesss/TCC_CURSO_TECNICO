<?php
	ob_start();	
	$_SESSION['logadoWeb'] = 0;
	//redireciona o usuario para a página de login
	echo '<script>window.location.href = "admin.php";</script>';
?>