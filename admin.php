<?php
  session_start();
  include "conexao.php";
?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="André Gonzaga">
    <link rel="sortcut icon" href="../site/assets/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Quicksand&display=swap" rel="stylesheet">
      <title>Sistema Etech Jobs</title>
  </head>

  <body>
    <div class="container text-center" style="margin-top: 180px;">
      <form class="form-signin col-md-4 offset-md-4" method="POST" id="selectID">
        <h2 class="form-signin-heading" style="font-family: 'Quicksand', sans-serif;">Sistema Etech Jobs</h2><br>
        
        <label for="inputUser" class="sr-only">Usuário</label>
        <div class="form-group">
          <select class="form-control" id="inputUser" autofocus required name="usuario" style="font-family: 'Quicksand', sans-serif;">
            <option>Usuário</option>
            <?php
              $Matriz = $conexao->prepare("select idUsuario, usuario from usuarios");
              $Matriz->execute();
              while ($Linha = $Matriz->fetch(PDO::FETCH_OBJ)){
            ?>
                <option value="<?=$Linha->usuario?>" style="margin-top: 10px; margin-bottom: 10px; font-family: 'Quicksand', sans-serif;" ><?=$Linha->usuario?></option>
            <?php
              }
            ?>
          </select>
        </div>
        <label for="inputPassword" class="sr-only">Senha</label>
        <input type="password" name="senha" id="inputPassword" class="form-control" placeholder="Senha" required style="font-family: 'Quicksand', sans-serif;"><br>
        <button class="btn btn-lg btn-block" type="submit" style="font-family: 'Quicksand', sans-serif; background: #45aaf2; color: white;">Acessar</button>
      </form>
	  <p class="text-center text-danger">
        <?php
          if(isset($_SESSION['loginErroWeb'])){
            echo $_SESSION['loginErroWeb'];
            unset($_SESSION['loginErroWeb']);
          }
        ?>
      </p>
		<p class="text-center text-success">
      <?php
        if(isset($_SESSION['logindeslogadoWeb'])){
          echo $_SESSION['logindeslogadoWeb'];
          unset($_SESSION['logindeslogadoWeb']);
        }
			?>
		</p>
    <?php 
      if(isset($_POST['usuario']) && isset($_POST['senha'])){
        $Matriz2 = $conexao->prepare("SELECT * FROM usuarios WHERE usuario = ? and senha = ? and ativo = 1 LIMIT 1");
        $Matriz2-> bindParam(1, $_POST['usuario']);
        $Matriz2-> bindParam(2, $_POST['senha']);
        $Matriz2->execute();
        $Linha2 = $Matriz2->fetch(PDO::FETCH_OBJ);

        if($Linha2){
          $_SESSION['usuarioIdWeb'] = $Linha2->idUsuario;
          $_SESSION['usuarioNomeWeb'] = $Linha2->usuario;
          $_SESSION['nAcesso'] = $Linha2->nAcesso;
          $_SESSION['logadoWeb'] = 1;
          echo '<script>window.location.href = "sistema.php";</script>';
        //Não foi encontrado um usuario na tabela usuário com os mesmos dados digitado no formulário
        //redireciona o usuario para a página de login
        }
        else{	
          //Váriavel global recebendo a mensagem de erro
          $_SESSION['logadoWeb'] = 0;
          $_SESSION['loginErroWeb'] = "Senha Inválida";
          echo '<script>window.location.href = "admin.php";</script>';
        }
      }
    ?>
    </div> <!-- /container -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>
