<script type="text/javascript" >
    $(document).ready(function() {

        function limpa_formulário_cep() {
            // Limpa valores do formulário de cep.
            $("#rua_profissional").val("");
            $("#bairro_profissional").val("");
            $("#cidade_profissional").val("");
            $("#estado_profissional").val("");
        }
        
        //Quando o campo cep perde o foco.
        $("#cep_profissional").blur(function() {

            //Nova variável "cep" somente com dígitos.
            var cep = $(this).val().replace(/\D/g, '');

            //Verifica se campo cep possui valor informado.
            if (cep != "") {

                //Expressão regular para validar o CEP.
                var validacep = /^[0-9]{8}$/;

                //Valida o formato do CEP.
                if(validacep.test(cep)) {

                    //Preenche os campos com "..." enquanto consulta webservice.
                    $("#rua_profissional").val("...");
                    $("#bairro_profissional").val("...");
                    $("#cidade_profissional").val("...");
                    $("#estado_profissional").val("...");

                    //Consulta o webservice viacep.com.br/
                    $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                        if (!("erro" in dados)) {
                            //Atualiza os campos com os valores da consulta.
                            $("#rua_profissional").val(dados.logradouro);
                            $("#bairro_profissional").val(dados.bairro);
                            $("#cidade_profissional").val(dados.localidade);
                            $("#estado_profissional").val(dados.uf);
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

<?php
    if(!isset($_SESSION['logadoWeb']) || $_SESSION['logadoWeb'] != 1){
        echo '<script>window.location.href = "admin.php";</script>';
    }

    function selected( $value, $selected ){
        return $value==$selected ? ' selected="selected"' : '';
    }

    //LOAD INFOS PROFISSIONAL
    $pegaID = $_GET['id'];
    $sql = "SELECT
                cad_profissional.idProf,
                servicos.tipoServico,
                servicos.descServico,
                cad_profissional.nomeProf,
                cad_profissional.rgProf,
                cad_profissional.cpfProf,
                cad_profissional.ruaProf,
                cad_profissional.numProf,
                cad_profissional.compProf,
                cad_profissional.bairroProf,
                cad_profissional.cidadeProf,
                cad_profissional.ufProf,
                cad_profissional.cepProf,
                cad_profissional.senha,
                cad_profissional.usuario,
                cad_profissional.emailProf,
                cad_profissional.estado_civilProf,
                cad_profissional.sexoProf,
                cad_profissional.senha2,
                cad_profissional.telefoneProf,
                cad_profissional.data_nascProf,
                cad_profissional.celularProf,
                cad_profissional.celular2Prof,
                cad_profissional.ativo,
                cad_profissional.mensalidade
            FROM
                cad_profissional
                INNER JOIN servicos ON cad_profissional.idProf = servicos.idProf 
            WHERE
                cad_profissional.idProf = $pegaID ";

            $username = "";
            $email = "";
            $senha = "";
            $senha2 = "";
            $nome = "";
            $rg = "";
            $cpf = "";
            $data_nascimento = "";
            $estado_civil = "";
            $sexo = "";
            $telefone = "";
            $cel1 = "";
            $cel2 = "";
            $cep = "";
            $endereco = "";
            $numeroEnd = "";
            $complementoEnd = "";
            $bairroEnd = "";
            $cidadeEnd = "";
            $estadoEnd = "";
            $ativo = "";
            $mensalidade = "";
            $descServico = "";
            $tipoServico = "";

            if(isset($pegaID) && $pegaID != 0 || $pegaID != "" || $pegaID != NULL){
                $Matriz2 = $conexao->prepare($sql);
                $Matriz2-> bindParam(1, $pegaID);
                $Matriz2->execute();
                $Linha2 = $Matriz2->fetch(PDO::FETCH_OBJ);
                $username = $Linha2->usuario;
                $email = $Linha2->emailProf;
                $senha = $Linha2->senha;
                $senha2 = $Linha2->senha2;
                $nome = $Linha2->nomeProf;
                $rg = $Linha2->rgProf;
                $cpf = $Linha2->cpfProf;
                $data_nascimento = $Linha2->data_nascProf;
                $estado_civil = $Linha2->estado_civilProf;
                $sexo = $Linha2->sexoProf;
                $telefone = $Linha2->telefoneProf;
                $cel1 = $Linha2->celularProf;
                $cel2 = $Linha2->celular2Prof;
                $cep = $Linha2->cepProf;
                $endereco = $Linha2->ruaProf;
                $numeroEnd = $Linha2->numProf;
                $complementoEnd = $Linha2->compProf;
                $bairroEnd = $Linha2->bairroProf;
                $cidadeEnd = $Linha2->cidadeProf;
                $estadoEnd = $Linha2->ufProf;
                $ativo = $Linha2->ativo;
                $descServico = $Linha2->descServico;
                $tipoServico = $Linha2->tipoServico;
                $mensalidade = $Linha2->mensalidade;
            }

    //SALVA AS ALTERAÇÕES
    if(isset($_POST['botao']) && $_POST['botao'] == 'dadospessoais'){
        if($_POST["senha"] == $_POST["senha2"]){
            if(!empty($_POST['senha']) || !empty($_POST['senha2'])){
    
                $senha = $_POST["senha"];
                $senha2 = $_POST["senha2"];
                $estado_civil = $_POST["estado_civil"];
                $telefone = $_POST["telefone"];
                $cel1 = $_POST["cel1"];
                $cel2 = $_POST["cel2"];
                $cep = $_POST["cep"];
                $endereco = $_POST["endereco"];
                $numeroEnd = $_POST["numeroEnd"];
                $complementoEnd = $_POST["complementoEnd"];
                $bairroEnd = $_POST["bairroEnd"];
                $cidadeEnd = $_POST["cidadeEnd"];
                $estadoEnd = $_POST["estadoEnd"];
                $username = $_POST["username"];
                $email = $_POST["email"];
                $nome = $_POST["nome"];
                $rg = $_POST["rg"];
                $cpf = $_POST["cpf"];
                $data_nascimento = $_POST["data_nascimento"];
                $sexo = $_POST["sexo"];
                $ativo = $_POST["ativo"];
                $tipoServico = $_POST['tipoServico'];
                $descServico = $_POST['descServico'];

                try{
                    $Comando = $conexao->prepare("UPDATE cad_profissional INNER JOIN servicos ON cad_profissional.idProf = servicos.idProf 
                    SET senha=?, senha2=?, estado_civilProf=?, telefoneProf=?, celularProf=?, celular2Prof=?, cepProf=?, ruaProf=?, numProf=?, 
                    compProf=?, bairroProf=?, cidadeProf=?, ufProf=?, usuario=?, emailProf=?, nomeProf=?, rgProf=?, cpfProf=?, 
                    data_nascProf=?, sexoProf=?, ativo=?, tipoServico=?, descServico=? WHERE cad_profissional.idProf = $pegaID");
                    $Comando-> bindParam(1, $senha);
                    $Comando-> bindParam(2, $senha2);
                    $Comando-> bindParam(3, $estado_civil);
                    $Comando-> bindParam(4, $telefone);
                    $Comando-> bindParam(5, $cel1);
                    $Comando-> bindParam(6, $cel2);
                    $Comando-> bindParam(7, $cep);
                    $Comando-> bindParam(8, $endereco);
                    $Comando-> bindParam(9, $numeroEnd);
                    $Comando-> bindParam(10, $complementoEnd);
                    $Comando-> bindParam(11, $bairroEnd);
                    $Comando-> bindParam(12, $cidadeEnd);
                    $Comando-> bindParam(13, $estadoEnd);
                    $Comando-> bindParam(14, $username);
                    $Comando-> bindParam(15, $email);
                    $Comando-> bindParam(16, $nome);
                    $Comando-> bindParam(17, $rg);
                    $Comando-> bindParam(18, $cpf);
                    $Comando-> bindParam(19, $data_nascimento);
                    $Comando-> bindParam(20, $sexo);
                    $Comando-> bindParam(21, $ativo);
                    $Comando-> bindParam(22, $tipoServico);
                    $Comando-> bindParam(23, $descServico);
                
                    if($Comando->execute()){

                        if($Comando->rowCount()>0){
                            echo "<script>Swal.fire({position: 'center', type: 'success', title: 'Informações atualizadas com sucesso!', showConfirmButton: false, timer: 1700})</script>";
                            echo ('<meta http-equiv="refresh"content=1;>');
                            
                        }
                        else{
                            echo "<script>Swal.fire({ type: 'error', title: 'Não foi possível atualizar as informações ou não houveram mudanças!', showConfirmButton: false, timer: 1700})</script>";
                        }
                    }
                    else{
                        throw new PDOException("Erro:Não foi possivel executar sql");
                    }
                }
                catch(PDOException $erro){
                    echo "Erro" . $erro->getMessage();
                }
            }
            else{
                echo "<script>Swal.fire({ type: 'error', title: 'Por favor preencha a senha!', showConfirmButton: false, timer: 1700})</script>";
            }
        }
        else{
            echo "<script>Swal.fire({ type: 'error', title: 'As senhas devem coincidir!', showConfirmButton: false, timer: 1700})</script>";
        }
    }
?>

<div class="container">
    <form method="POST">
        <div class="container-fluid">
            <h1 id="cadastro-titulo">Perfil do Profissional</h1>
        </div>
        <div class="row" style=" padding: 20px;">
            <div class="container col-md-8" id="cadProfissionais">
                <div class="row">
                    <h4 style="border-bottom: 2px solid #58bbc9;">Dados de Acesso</h4>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="user">Usuário*</label>
                        <input type="text" class="form-control" id="user" placeholder="" name="username" required maxlength="20" value="<?=$username?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email">Email*</label>
                        <input type="text" class="form-control" id="email" placeholder="" name="email" required maxlength="50" value="<?=$email?>">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="senha">Senha*</label>
                        <input type="password" class="form-control" id="senha" placeholder="" name="senha" required maxlength="20" value="<?=$senha?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="repeat_senha">Repita Senha*</label>
                        <input type="password" class="form-control" id="repeat_senha" placeholder="" name="senha2" required maxlength="20" value="<?=$senha2?>">
                    </div>
                </div><hr />
                <div class="row">
                    <h4 style="border-bottom: 2px solid #58bbc9;">Dados Pessoais</h4>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="nome">Nome Completo*</label>
                        <input type="text" class="form-control" id="nome" placeholder="" name="nome" required maxlength="70" value="<?=$nome?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="rg_profissional">RG*</label>
                        <input type="text" class="form-control" id="rg_profissional" placeholder="" name="rg" required maxlength="12" value="<?=$rg?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="cpf_profissional">CPF*</label>
                        <input type="text" class="form-control" id="cpf_profissional" placeholder="" name="cpf" required maxlength="14" value="<?=$cpf?>">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="rg">Data de Nascimento*</label>
                        <input type="date" class="form-control" id="rg" placeholder="" name="data_nascimento" required maxlength="10" value="<?=$data_nascimento?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="estado_civil">Estado Civil*</label>
                        <select id="estado_civil" class="form-control" name="estado_civil" value="<?=$estado_civil?>">
                            <option value="solteiro" <?php echo selected( 'solteiro', $estado_civil );?>>Solteiro(a)</option>
                            <option value="casado" <?php echo selected( 'casado', $estado_civil ); ?>>Casado(a)</option>
                            <option value="separado" <?php echo selected( 'separado', $estado_civil ); ?>>Separado(a)</option>
                            <option value="divorciado" <?php echo selected( 'divorciado', $estado_civil ); ?>>Divorciado(a)</option>
                            <option value="viuvo" <?php echo selected( 'viuvo', $estado_civil ); ?>>Viúvo(a)</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="sexo">Sexo*</label>
                        <select id="sexo" class="form-control" name="sexo">
                            <option value="M" <?php echo selected( 'M', $sexo ); ?>>Masculino</option>
                            <option value="F" <?php echo selected( 'F', $sexo ); ?>>Feminino</option>
                            <option value="O" <?php echo selected( 'O', $sexo ); ?>>Outro</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="telefone_fixo">Telefone Fixo</label>
                        <input type="text" class="form-control" id="tel_profissional" placeholder="" name="telefone" maxlength="14" value="<?=$telefone?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="celular">Celular*</label>
                        <input type="text" class="form-control" id="cel_profissional" placeholder="" name="cel1" required maxlength="15" value="<?=$cel1?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="celular_2">Celular 2</label>
                        <input type="text" class="form-control" id="cel2_profissional" placeholder="" name="cel2" maxlength="15" value="<?=$cel2?>">
                    </div>
                </div><hr />
                <div class="row">
                    <h4 style="border-bottom: 2px solid #58bbc9;">Endereço</h4>
                </div>
                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="nome">CEP*</label>
                        <input type="text" class="form-control" id="cep_profissional" placeholder="" name="cep" required maxlength="9" value="<?=$cep?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="rg">Endereço*</label>
                        <input type="text" class="form-control" id="rua_profissional" placeholder="" name="endereco" required maxlength="50" value="<?=$endereco?>">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="nome">Número*</label>
                        <input type="text" class="form-control" id="nome" placeholder="" name="numeroEnd" required maxlength="5" value="<?=$numeroEnd?>">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-3">
                        <label for="complemento">Complemento</label>
                        <input type="text" class="form-control" id="complemento" placeholder="" name="complementoEnd" maxlength="20" value="<?=$complementoEnd?>">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="rg">Bairro*</label>
                        <input type="text" class="form-control" id="bairro_profissional" name="bairroEnd" placeholder="" required maxlength="30" value="<?=$bairroEnd?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="rg">Cidade*</label>
                        <input type="text" class="form-control" id="cidade_profissional" name="cidadeEnd" placeholder="" required maxlength="50" value="<?=$cidadeEnd?>">
                    </div>
                    <div class="form-group col-md-2">
                        <label for="nome">Estado / UF*</label>
                        <input type="text" class="form-control" id="estado_profissional" placeholder="" name="estadoEnd" required maxlength="2" value="<?=$estadoEnd?>">
                    </div>
                </div><hr />
                <div class="row">
                    <h4 style="border-bottom: 2px solid #58bbc9;">Serviço</h4>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="tipoServico">Tipo de Serviço</label>
                        <select class="form-control" id="tipoServico" name="tipoServico">
                        <?php   
                            $Comando = $conexao->prepare('SELECT servico FROM tiposervico ORDER BY servico');
                            $Comando->execute();
                            while ($Linha = $Comando->fetch(PDO::FETCH_OBJ)){
                        ?>
                            <option value="<?=$Linha->servico?>" <?php echo selected( $tipoServico, $Linha->servico );?>><?=$Linha->servico?></option>
                        <?php
                            }
                        ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="descServico">Descrição do Serviço</label>
                        <textarea class="form-control" id="descServico" rows="5" name="descServico"><?=$descServico?></textarea>
                    </div>
                </div>
                <div class="row" style="margin-top: 20px;">
                    <button name="botao" value="dadospessoais" type="submit" class="btn btn-outline-primary col-md-3 offset-9">Salvar</button>
                </div>
            </div>
            <div class="container col-md-3 offset-md-1" style="border: 1px whitesmoke solid; background: white; height: 215px; border-radius: 10px;">
                <div class="row justify-content-center" style="background-color: rgb(23,49,62); color: white; border-bottom: lightgray; border-top-left-radius: 10px; border-top-right-radius: 10px; padding: 10px;">
                    <h3>Painel de Controle</h3>
                </div>
                <div class="row justify-content-center" style="padding: 5px; margin-top: 10px;">
                    <h5 class="col-md-6" style="padding-top: 8px;">Liberação</h5>
                    <div class="col-md-6" style="margin-top: 2px;">
                        <select class="form-control" id="ativo" name="ativo">
                            <option value="1" <?php echo selected( '1', $ativo );?>>Sim</option>
                            <option value="0" <?php echo selected( '0', $ativo );?>>Não</option>
                        </select>
                    </div>
                </div><hr />
                <div class="row justify-content-center" style="padding: 5px; margin-top: 10px;">
                    <h5 class="col-md-6" style="padding-top: 8px;">Mensalidade</h5>
                    <div class="col-md-6" style="margin-top: 2px;">
                        <select class="form-control" id="ativo" name="ativo">
                            <option value="1" <?php echo selected( '1', $mensalidade );?>>Sim</option>
                            <option value="0" <?php echo selected( '0', $mensalidade );?>>Não</option>
                        </select>
                    </div>
                </div>              
            </div>
        </div>
    </form>
</div>
        
<style>
    .liga-desliga__checkbox {
        position: absolute;
        left: -9999px;
    }

    .liga-desliga__botao {
        display: inline-block;
        vertical-align: middle;
        position: relative;
        cursor: pointer;
    }

    .liga-desliga__botao::before,
    .liga-desliga__botao::after {
        content: "";
        box-shadow: 0 0 0 1px #CCC;
        transition: all 0.25s ease;
    }

    .liga-desliga__botao::before {
        display: inline-block;
        border-radius: 1em;
        height: 1.5em;
        width: 2.7em;
        margin-right: 0.5em;
        background: #900;
    }

    .liga-desliga__botao::after {
        position: absolute;
        top: 0.16em;
        left: 0.25em;
        width: 1.16em;
        height: 1.16em;
        border-radius: 100%;
        background: #FFF;
    }

    .liga-desliga__checkbox:checked + .liga-desliga__botao::before {
        background: #55D069;
    }

    .liga-desliga__checkbox:checked + .liga-desliga__botao::after {
        left: 1.35em;
    }

    .liga-desliga__checkbox:focus + .liga-desliga__botao::before {
        outline: 3px dotted #CCC;
    }
</style>