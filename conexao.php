<?php
    $BdD = 'tcc';
	$Usuario = 'root';
	$Senha = "";

	try{
 		$conexao = new PDO("mysql:host=localhost; dbname=$BdD", "$Usuario", "$Senha");
 		$conexao -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 		$conexao -> exec("set names utf8");
	}
	
	catch (PDOException $erro){
 		echo 'erro na conexao:' .$erro->getMessage(); 
	}
?>