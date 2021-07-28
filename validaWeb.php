<?php
	session_start();	
	//Incluindo a conexão com banco de dados
	include_once("conexao.php");	
	//O campo usuário e senha preenchido entra no if para validar
	if((isset($_POST['usuario'])) && (isset($_POST['senha']))){
		$usuario = $_POST['usuario'];
		$senha = $_POST['senha'];
			
		//Buscar na tabela usuario o usuário que corresponde com os dados digitado no formulário
		$result_usuario = "SELECT * FROM usuarios WHERE usuario = '$usuario' and senha = '$senha' and ativo = 1 LIMIT 1";
		$resultado_usuario = mysqli_query($conexao, $result_usuario);
		$resultado = mysqli_fetch_assoc($resultado_usuario);
		var_dump($resultado);
		//Encontrado um usuario na tabela usuário com os mesmos dados digitado no formulário
		if(isset($resultado)){
			$_SESSION['usuarioIdWeb'] = $resultado['idUsuario'];
			$_SESSION['usuarioNomeWeb'] = $resultado['usuario'];
			$_SESSION['usuarioAtivoWeb'] = $resultado['ativo'];
			
		//Não foi encontrado um usuario na tabela usuário com os mesmos dados digitado no formulário
		//redireciona o usuario para a página de login
		}else{	
			//Váriavel global recebendo a mensagem de erro
			$_SESSION['loginErroWeb'] = "Usuário ou senha Inválido";
			window.location.href = "admin.php"
		}
	//O campo usuário e senha não preenchido entra no else e redireciona o usuário para a página de login
	}else{
		$_SESSION['loginErroWeb'] = "Usuário ou senha inválido";
		window.location.href = "admin.php"
	}
?>