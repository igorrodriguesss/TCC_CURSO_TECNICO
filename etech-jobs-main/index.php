<?php
	include 'conexao.php';
    session_start();
?>
<html>
	<head>
		<meta charset="UTF-8">
        <title>Etech Jobs</title>
        <link type="text/css" rel="stylesheet" href="./assets/style/style.css"/>
        <link rel="sortcut icon" href="./assets/img/favicon.ico" type="image/x-icon">
        <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500&display=swap" rel="stylesheet">
        <!-- BOOTSTRAP CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' rel='stylesheet'/>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-1.11.2.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
        <!-- UIkit CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.5.5/dist/css/uikit.min.css" />
        <!-- UIkit JS -->
        <script src="https://cdn.jsdelivr.net/npm/uikit@3.5.5/dist/js/uikit.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/uikit@3.5.5/dist/js/uikit-icons.min.js"></script>
	</head>
	<body style="font-family: 'Quicksand', sans-serif;">
        <!-- MENU -->
        <div class="container-fluid" id="banner" style="padding-top: 20px;">
            <div class="row col-md-12" style="color: white;">
                <div class="container-fluid col-md-11" style="padding-top: 10px;">
                    <div class="row justify-content-center">
                        <div class="col-md-1">
                            <a href="index.php" style=" position: fixed;z-index: 9999; margin-top: -20px;"><img class="img-fluid" src="./assets/img/logo.png" height="70" width="70"></a>
                        </div>
                        <div class="col-md-1 offset-md-6">
                            <p class="menu" style="width: 90px;"><a class="item-menu" href="index.php" style="font-size: 18px;">Home</a></p>
                        </div>
                        <div class="col-md-1" style="margin-right: 20px;">
                            <p class="menu " style="width: 130px;"><a class="item-menu" href="?p=sobre" style="font-size: 18px;">Sobre Nós</a></p>
                        </div>
                        <div class="col-md-1" style="margin-right: 50px;">
                            <p class="menu" style="width: 155px;"><a class="item-menu" href="?p=fale-conosco" style="font-size: 18px;">Fale Conosco</a></p>
                        </div>
                        <div class="col-md-1">
                            <p class="menu"><a class="item-menu" href="?p=faq" style="font-size: 18px;">FAQ</a></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="dropdown show">
                        <a href="#" id="login" id="dropdownMenuLink" role="button"  data-toggle="dropdown" aria-expanded="false"><i class="fa fa-user-circle-o fa-3x" aria-hidden="true"></i></a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                            <?php
                            if(isset($_SESSION['logado']) && $_SESSION['logado'] == 1){ 
                            ?>
                                <a class="dropdown-item" style="font-size: 18px;"><strong><?=$_SESSION['nome']?></strong></a>
                                <div class="dropdown-divider"></div>
                            <?php
                            }else{
                            ?>
                                <a class="dropdown-item" href="?p=login">Entrar / Cadastrar-se</a>
                            <?php
                            }
                            ?>
                            <?php
                            if(isset($_SESSION['logado']) && $_SESSION['logado'] == 1){
                            ?>
                                <a class="dropdown-item" href="?p=meuperfil"><i class="fa fa-address-card"></i> Meu Perfil</a>
                                <a class="dropdown-item" href="?p=solicitacoes"><i class="fa fa-bell"></i> Minhas Solicitações</a>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalMensalidade"><i class="fa fa-credit-card"></i> Status Mensalidade</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="?p=sair"><i class="fa fa-sign-out"></i> Sair</a>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- MODAL MENSALIDADE -->
        <div class="modal fade" id="modalMensalidade" tabindex="-1" role="dialog" aria-labelledby="modalMensalidade" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Status Mensalidade</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <div class="form-group col-md-12">
                        <h5><?php if($_SESSION['status'] == 0){ echo 'Mensalidade Inativa'; }else{ echo 'Mensalidade Ativa';}?></h5>
                    </div><br><br>
                    <?php
                    if($_SESSION['status'] == 1){
                    ?>
                        <div class="form-group col-md-12">
                            <label for="nome">Ultimo pagamento em:</label>
                            <input type="text" class="form-control" id="estado_profissional" placeholder="" name="data_mensalidade" required maxlength="2" value="<?=$_SESSION['data_mensalidade']?>" style="border:none; background: none;" readonly>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="nome">Expira em:</label>
                            <input type="text" class="form-control" id="estado_profissional" placeholder="" name="data_mensalidade" required maxlength="2" value="<?=$_SESSION['expira']?>" style="border:none; background: none;" readonly>
                        </div>
                    <?php
                    }else{
                    ?>
                        <div class="form-group col-md-12">
                            <text><a href="?p=pagamento">Adquira ja mais tempo para exibir seu trabalho em nossas vitrines</a></text>
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
                </div>
            </div>
        </div>


        <!-- CORPO INCLUDE PHP -->
        <?php
			function verificaPagina($p){
				if(file_exists($p . '.php')){
					return $p . '.php';
				}else{
					return 'error404.php';
				}
			}
			if(!isset($_GET['p']) || empty($_GET['p'])){
				include 'corpoIndex.php';
			}
			else if(isset($_GET['p'])){
                include verificaPagina($_GET['p']);
            }
        ?><!--END CORPO INCLUDE PHP -->
        <footer>
            <div class="container-fluid" id="rodape" >
                <div class="row justify-content-center">
                    <div class="col-md-2">
                        <img class="img-fluid" src="./assets/img/logo.png">
                    </div>
                    <div class="col-md-2">
                        <text class="rodapeTitulo" style="border-bottom: rgb(66,218,250) solid;">EtechJobs</text>
                        <div class="alinhamentoRodape">
                            <ul style="margin-top:40px;"><a class="item-menu" href="?p=sobrenos">Sobre Nós</a></ul>
                            <ul><a class="item-menu" href="?p=fale-conosco">Fale Conosco</a></ul>
                            <ul><a class="item-menu" href="?p=faq">FAQ</a></ul>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <text class="rodapeTitulo" style="border-bottom: rgb(66,218,250) solid;">Serviços</text>
                        <div class="alinhamentoRodape">
                            <ul style="	margin-top:40px;"><a href="" class="item-menu">Advocacia</a></ul>
                            <ul><a href="" class="item-menu">T.I.</a></ul>
                            <ul><a href="" class="item-menu">Financeiro</a></ul>
                            <ul><a href="" class="item-menu">Servicos Domésticos</a></ul>
                        </div>
                    </div>
                    <div clas="col-md-2">
                        <div class="row">
                            <text class="rodapeTitulo" style="border-bottom: rgb(66,218,250) solid;">Onde Estamos</text>
                        </div>
                        <iframe class=" col-md-11" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3653.457967787306!2d-46.55150964883684!3d-23.69533438454097!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94ce4230e86e2165%3A0xa945f637af54fea3!2sETEC%20Lauro%20Gomes!5e0!3m2!1spt-BR!2sbr!4v1591929854000!5m2!1spt-BR!2sbr" width="250" height="200" frameborder="0;" style="border:0; margin-top:40px; margin-left: 20px;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>						
                    </div>
                    <div class="col-md-1">
                        <ul style="font-size:30px;margin-top:40px;">
                            <ul><a href="https://facebook.com" class="item-menu"><i class="fa fa-facebook-square"></i></a></ul>
                            <ul id="linkedin"><a href="https://linkedin.com" class="item-menu"><i class="fa fa-linkedin"></i></a></ul>
                            <ul id="instagram"><a href="https://instagram.com" class="item-menu"><i class="fa fa-instagram"></i></a></ul>
                            <ul id="youtube"><a href="https://twitter.com" class="item-menu"><i class="fa fa-youtube"></i></a></ul>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="container-fluid" id="rodape-baixo">
                <div class="row justify-content-center" id="linha2-rodape">
                    <p>Copyright © EtechJobs 2020. Todos os direitos reservados.</p>
                </div>
            </div>
        </footer>

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</hmtl>