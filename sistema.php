<?php
    session_start();
    include "conexao.php";
    if(!isset($_SESSION['logadoWeb']) || $_SESSION['logadoWeb'] != 1){
        echo '<script>window.location.href = "admin.php";</script>';
    }
?>
<html lang="pt-br">  
    <head>
        <!-- META TAGS OBRIGATÓRIAS -->
        <meta charset='UTF-8'>
        <title>Sistema Etech Jobs</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- BOOTSTRAP CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Quicksand&display=swap" rel="stylesheet">
        <link rel="sortcut icon" href="../site/assets/img/favicon.ico" type="image/x-icon">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css" rel="stylesheet">      
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-1.11.2.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
        <!-- MASCARAS JQUERY -->
        <script>
            $('#cep_cliente').mask('00000-000');
            $('#cel_cliente').mask('(00)00000-0000');
            $('#tel_cliente').mask('(00)0000-0000');
            $('#rg_cliente').mask('00.000.000-0');
            $('#cpf_cliente').mask('000.000.000-00');
        </script>
         <!-- BUSCA CEP -->
        <script type="text/javascript">

            $(document).ready(function() {

                function limpa_formulário_cep() {
                    // Limpa valores do formulário de cep.
                    $("#rua_cliente").val("");
                    $("#bairro_cliente").val("");
                    $("#cidade_cliente").val("");
                    $("#estado_cliente").val("");
                }
                
                //Quando o campo cep perde o foco.
                $("#cep_cliente").blur(function() {

                    //Nova variável "cep" somente com dígitos.
                    var cep = $(this).val().replace(/\D/g, '');

                    //Verifica se campo cep possui valor informado.
                    if (cep != "") {

                        //Expressão regular para validar o CEP.
                        var validacep = /^[0-9]{8}$/;

                        //Valida o formato do CEP.
                        if(validacep.test(cep)) {

                            //Preenche os campos com "..." enquanto consulta webservice.
                            $("#rua_cliente").val("...");
                            $("#bairro_cliente").val("...");
                            $("#cidade_cliente").val("...");
                            $("#estado_cliente").val("...");

                            //Consulta o webservice viacep.com.br/
                            $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                                if (!("erro" in dados)) {
                                    //Atualiza os campos com os valores da consulta.
                                    $("#rua_cliente").val(dados.logradouro);
                                    $("#bairro_cliente").val(dados.bairro);
                                    $("#cidade_cliente").val(dados.localidade);
                                    $("#estado_cliente").val(dados.uf);
                                } //end if.
                                else {
                                    //CEP pesquisado não foi encontrado.
                                    limpa_formulário_cep();
                                    alert("CEP não encontrado.");
                                }
                            });
                        } //end if.
                        else {
                            //cep é inválido.
                            limpa_formulário_cep();
                            alert("Formato de CEP inválido.");
                        }
                    } //end if.
                    else {
                        //cep sem valor, limpa formulário.
                        limpa_formulário_cep();
                    }
                });
            });
        </script>
    </head>
    <body style="background: #f1f2f6; font-family: 'Quicksand', sans-serif;" id="corpo">
    <!-- MENU -->
        <div class="col-sm-4 col-md-3 sidebar" style="position: absolute; z-index: 100; margin-top: 15px; background: transparent;">
            <!-- MENU HIDDEN -->
            <div class="mini-submenu">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </div><!-- END MENU HIDDEN -->
            <!--CORPO MENU -->
            <div class="list-group" id="MainMenu">
                <span href="#" class="list-group-item active" id="menuMenu">
                    <p class="top-menu">Menu</p>
                    <span class="pull-right" id="slide-submenu">
                        <i class="fa fa-times"></i>
                    </span>
                </span>
                <!-- BOTÔES MENU -->
                <a href="sistema.php" class="list-group-item">
                    <p class="p-menu"><i class="fas fa-home"></i> Home</p>
                </a>
                <a href="?page=consultacon" class="list-group-item">
                    <p class="p-menu"><i class="fa fa-bell"></i> Gerenciar Chamados</p>
                </a>
                <a href="?page=consultapro" class="list-group-item">
                    <p class="p-menu"><i class="fa fa-address-card"></i> Gerenciar Profissionais</p>
                </a>
                <a href="?page=sairWeb" class="list-group-item">
                    <p class="p-menu"><i class="fa fa-user"></i> Desconectar</p>
                </a>
            </div>
        </div>
        <!-- HEADER -->
        <div class="container-fluid col-sm-12" style="background: rgb(25,52,65); padding: 5px 0 5px 5px; height: 83px;" id="header">
            <p class="text-center col-md-12"><img class="col-sm-1" id="logo" class="img-fluid" src="assets/img/logo.png"></p>
        </div>
        <div class="container" style="background: transparent; border:none; padding: 15px; color: black;">
            <div class="row align-items-center" style="text-align: center; margin: 0;">
            </div>
        </div>

        <!-- INCLUDE CORPO PHP -->
		<?php
        
        function verificaPagina($page){
            if(file_exists($page . '.php')){
                return $page . '.php';
            }else{
                return 'error404.php';
            }
        }
        if(!isset($_GET['page']) || empty($_GET['page'])){
            include 'consultapro.php';
        }
        else if(isset($_GET['page'])){
            include verificaPagina($_GET['page']);
        }
        ?>
        
        <!-- FOOTER -->

        <!-- MENU HIDDEN -->
        <script>
            $(function(){
                $('.mini-submenu').on('click',function(){		
                    $(this).next('.list-group').toggle('slide');
                    $('.mini-submenu').hide();
                })
                $('#slide-submenu').on('click',function() {
                    $(this).closest('.list-group').fadeOut('slide',function(){
                        $('.mini-submenu').fadeIn();
                    });
                });
            })
        </script><!-- END MENU HIDDEN -->
        <script>
            $("#selectConsulta").change(function(){
                $('#formOrcamento').submit();
            })

        </script>


        <!-- STYLE -->
        <style>   
            /* MENU HIDDEN */
            .mini-submenu{
                display:block;
                background-color: rgba(0, 0, 0, 0);  
                padding: 5px;  
                position: absolute;
                width: 30px;
                transition: all 0.15s linear;
                border: none;
                transform: scale(1.6);
            }
            .mini-submenu:hover{
                cursor: pointer;
            }
            .mini-submenu .icon-bar {
                border-radius: 1px;
                display: block;
                height: 3px;
                width: 22px;
                margin-top: 3px;
            }
            .mini-submenu .icon-bar {
                background-color: white;
            }
            .list-group{
                display: none;
                position: fixed;
            }
            #menuMenu{
                background: linear-gradient(-100deg, rgb(205, 205, 205) 20%, transparent 65%);
                border: none;
            }
            .list-group-item:nth-child(1):hover {
                background: #ecf0f1;
            }
            .list-group-item:nth-child(2):hover {
                background: #ecf0f1;
            }
            .list-group-item:nth-child(3):hover {
                background: #ecf0f1;
            }
            .list-group-item:nth-child(4):hover {
                background: #ecf0f1;
            }
            .list-group-item:nth-child(5):hover {
                background: #ecf0f1;
            }
            .list-group-item:nth-child(6):hover {
                background: #ecf0f1;
            }
            .list-group-item:nth-child(7):hover {
                background: #ecf0f1;
            }
            .list-group-item:nth-child(8):hover {
                background: #ecf0f1;
            }
            #slide-submenu{
                background: rgba(0, 0, 0, 0.45);
                display: inline-block;
                padding: 0 8px;
                border-radius: 4px;
                cursor: pointer;
                float: right;
            }
            .top-menu{
                margin: 0;
                font-family: 'Quicksand', sans-serif;
                color: White;
                display: inline-block;
                font-weight: 600;
            }
            .p-menu{
                margin: 0;
                font-family: 'Quicksand', sans-serif;
                color: black;
                display: inline-block;
            }
        </style>

        <!-- JS BOOTSTRAP -->
        <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    </body>
</html>