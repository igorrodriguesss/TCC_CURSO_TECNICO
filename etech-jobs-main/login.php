<?php
    include "conexao.php";
    if(isset($_SESSION['logado']) && $_SESSION['logado'] == 1){
        echo '<script>window.location.href = "index.php?p=meuperfil";</script>';
    }
?>
<div class="container text-center" style="padding: 60px;">
    <div class="row justify-content-center">
        <form class="form-signin col-md-4 " method="POST" id="selectID" style="border: 1px solid whtesmoke; background: whitesmoke; padding: 20px; border-radius: 5px;">
            <h2 class="form-signin-heading" style="font-family: 'Quicksand', sans-serif;">Login</h2><br>
            <label for="inputUser" class="sr-only">Usuário</label>
            <input type="text" class="form-control" name="usuario" placeholder='Usuario' style="margin-bottom: 10px;">
            <label for="inputPassword" class="sr-only">Senha</label>
            <input type="password" name="senha" id="inputPassword" class="form-control" placeholder="Senha" required style="font-family: 'Quicksand', sans-serif;">
            <a href="?p=recsenha"><h6 style="margin-top: 5px;">Esqueceu sua senha?</h6></a><br>
            <p class="text-center text-danger">
                <?php
                if(isset($_SESSION['loginErro'])){
                    echo $_SESSION['loginErro'];
                    unset($_SESSION['loginErro']);
                }
                ?>
            </p>
            <p class="text-center text-success">
                <?php
                if(isset($_SESSION['logindeslogado'])){
                    echo $_SESSION['logindeslogado'];
                    unset($_SESSION['logindeslogado']);
                }
                ?>
            </p>
            <button class="btn btn-lg btn-block" type="submit" style="font-family: 'Quicksand', sans-serif; background: #45aaf2; color: white;">Acessar</button>
        </form>
        <?php 
            if(isset($_POST['usuario']) && isset($_POST['senha'])){
            $Matriz2 = $conexao->prepare("SELECT * FROM cad_profissional WHERE usuario = ? and senha = ? and ativo = 1 LIMIT 1");
            $Matriz2-> bindParam(1, $_POST['usuario']);
            $Matriz2-> bindParam(2, $_POST['senha']);
            $Matriz2->execute();
            $Linha2 = $Matriz2->fetch(PDO::FETCH_OBJ);
                if($Linha2){
                    $_SESSION['usuarioId'] = $Linha2->idProf;
                    $_SESSION['nickname'] = $Linha2->usuario;
                    $_SESSION['nome'] = $Linha2->nomeProf;
                    $_SESSION['sexo'] = $Linha2->sexoProf;
                    $_SESSION['status'] = $Linha2->mensalidade;
                    $_SESSION['expira'] = $Linha2->data_expira_mensalidade;
                    $_SESSION['data_mensalidade'] = $Linha2->data_mensalidade;
                    $_SESSION['logado'] = 1;
                    echo '<script>window.location.href = "index.php";</script>';
                //Não foi encontrado um usuario na tabela usuário com os mesmos dados digitado no formulário
                //redireciona o usuario para a página de login
                }
                else{
                    //Váriavel global recebendo a mensagem de erro
                    $_SESSION['logado'] == 0;
                    $_SESSION['loginErro'] = "Usuario ou Senha Inválida";
                    echo '<script>window.location.href = "index.php?p=login";</script>';
                }
            }
        ?>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-4" style="border: 1px solid whtesmoke; background: whitesmoke; border-radius: 5px; padding-top: 13px;">
            <p>Não tem uma conta? <a href="?p=cadastro">Cadastre-se!</a></p>
        </div>
    </div>
    <br>
</div> <!-- /container -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
