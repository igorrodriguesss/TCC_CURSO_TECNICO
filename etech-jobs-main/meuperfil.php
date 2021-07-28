<?php
	if(!isset($_SESSION['logado']) || $_SESSION['logado'] != 1){
        echo '<script>window.location.href = "login.php";</script>';
    }

    function selected( $value, $selected ){
        return $value==$selected ? ' selected="selected"' : '';
    }


    //LOAD DAS INFOS DO PROFISSIONAL
    $pegaID = $_SESSION['usuarioId'];
    $sql = "SELECT * FROM cad_profissional WHERE idProf = $pegaID";

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
    $mensalidade = "";
    $data_mensalidade = "";
    $data_expira_mensalidade = "";

    if(isset($_SESSION)){
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
        $mensalidade = $Linha2->mensalidade;
        $data_mensalidade = $Linha2->data_mensalidade;
        $data_expira_mensalidade = $Linha2->data_expira_mensalidade;
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

                try{
                    $Comando = $conexao->prepare("UPDATE cad_profissional SET senha=?, senha2=?, estado_civilProf=?,
                    telefoneProf=?, celularProf=?, celular2Prof=?, cepProf=?, ruaProf=?, numProf=?, compProf=?, bairroProf=?, 
                    cidadeProf=?, ufProf=? WHERE idProf = $pegaID");

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
<div class="container-fluid" style="padding: 50px;">
    <form method="POST">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <h1 id="cadastro-titulo">Meus Dados</h1>
            </div>
            <div class="row justify-content-center">
                <div class="" style="border-bottom: rgb(66,218,250) solid; width: 100px; margin-top: 5px; margin-bottom: 30px;"></div>
            </div>
        </div>
        <div class="row">
            <div class="container col-md-9" id="cadProfissionais">
                <div class="row" style="background: whitesmoke; padding: 15px;">
                    <h4 style="border-bottom: 2px solid #58bbc9;">Dados de Acesso</h4>
                </div>
                <div class="row" style="background: whitesmoke;">
                    <div class="form-group col-md-6">
                        <label for="user">Usuário*</label>
                        <input type="text" class="form-control" id="user" placeholder="" name="username" required maxlength="20" value="<?=$username?>" readonly>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email">Email*</label>
                        <input type="text" class="form-control" id="email" placeholder="" name="email" required maxlength="50" value="<?=$email?>" readonly>
                    </div>
                </div>
                <div class="row" style="background: whitesmoke;">
                    <div class="form-group col-md-6">
                        <label for="senha">Senha*</label>
                        <input type="password" class="form-control" id="senha" placeholder="" name="senha" required maxlength="20" value="<?=$senha?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="repeat_senha">Repita Senha*</label>
                        <input type="password" class="form-control" id="repeat_senha" placeholder="" name="senha2" required maxlength="20" value="<?=$senha2?>">
                    </div>
                </div>
                <div class="row" style="background: whitesmoke; padding: 15px;">
                    <h4 style="border-bottom: 2px solid #58bbc9;">Dados Pessoais</h4>
                </div>
                <div class="row" style="background: whitesmoke;">
                    <div class="form-group col-md-4">
                        <label for="nome">Nome Completo*</label>
                        <input type="text" class="form-control" id="nome" placeholder="" name="nome" required maxlength="70" value="<?=$nome?>" readonly>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="rg">RG*</label>
                        <input type="text" class="form-control" id="rg_profissional" placeholder="" name="rg" required maxlength="12" value="<?=$rg?>" readonly>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="nome">CPF*</label>
                        <input type="text" class="form-control" id="cpf_profissional" placeholder="" name="cpf" required maxlength="14" value="<?=$cpf?>" readonly>
                    </div>
                </div>
                <div class="row" style="background: whitesmoke;">
                    <div class="form-group col-md-4">
                        <label for="rg">Data de Nascimento*</label>
                        <input type="date" class="form-control" id="data_nascimento" placeholder="" name="data_nascimento" required maxlength="10" value="<?=$data_nascimento?>" readonly>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="estado_civil">Estado Civil*</label>
                        <select id="estado_civil" class="form-control" name="estado_civil" value="<?=$estado_civil?>">
                            <option value="solteiro" <?php echo selected( 'solteiro', $estado_civil ); ?>>Solteiro(a)</option>
                            <option value="casado" <?php echo selected( 'casado', $estado_civil ); ?>>Casado(a)</option>
                            <option value="separado" <?php echo selected( 'separado', $estado_civil ); ?>>Separado(a)</option>
                            <option value="divorciado" <?php echo selected( 'divorciado', $estado_civil ); ?>>Divorciado(a)</option>
                            <option value="viuvo" <?php echo selected( 'viuvo', $estado_civil ); ?>>Viúvo(a)</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="estado_civil">Sexo*</label>
                        <input type="text" class="form-control" id="sexo" placeholder="" name="telefone" value="<?php if($sexo === 'M'){ echo 'Masculino'; } elseif($sexo === 'F'){ echo 'Feminino'; }else{ echo 'Outros'; }?>" readonly>
                    </div>
                </div>
                <div class="row" style="background: whitesmoke;">
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
                </div>
                <div class="row" style="background: whitesmoke; padding: 15px;">
                    <h4 style="border-bottom: 2px solid #58bbc9;">Endereço</h4>
                </div>
                <div class="row" style="background: whitesmoke;">
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
                <div class="row" style="background: whitesmoke;">
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
                        <label for="nome">UF*</label>
                        <input type="text" class="form-control" id="estado_profissional" placeholder="" name="estadoEnd" required maxlength="2" value="<?=$estadoEnd?>">
                    </div>
                </div>
                <div class="row" style="margin-top: 20px;">
                    <button name="botao" value="dadospessoais" type="submit" class="btn btn-outline-primary col-md-3 offset-9">Salvar</button>
                </div>
            </div>
        </div>
    </form>
    <script>
    </script>
</div>