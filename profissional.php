<?php
    $pegaID = $_GET['cod'];
    $sql = "SELECT
                servicos.tipoServico,
                servicos.descServico,
                cad_profissional.nomeProf,
                cad_profissional.emailProf,
                cad_profissional.telefoneProf,
                cad_profissional.celularProf,
                cad_profissional.celular2Prof,
                cad_profissional.idProf 
            FROM
                cad_profissional
                INNER JOIN servicos ON cad_profissional.idProf = servicos.idProf 
            WHERE
                cad_profissional.idProf = $pegaID";

    $nome = "";
    $email = "";
    $telefone = "";
    $cel1 = "";
    $cel2 = "";


    if(isset($pegaID)){
        $Matriz2 = $conexao->prepare($sql);
        $Matriz2-> bindParam(1, $pegaID1);
        $Matriz2->execute();
        $Linha2 = $Matriz2->fetch(PDO::FETCH_OBJ);
        $nome = $Linha2->nomeProf;
        $telefone = $Linha2->telefoneProf;
        $cel1 = $Linha2->celularProf;
        $cel2 = $Linha2->celular2Prof;
        $email = $Linha2->emailProf;
        $tipoServico = $Linha2->tipoServico;
        $descServico = $Linha2->descServico;
    }
    
    if(isset($_POST['botao']) && $_POST['botao'] === 'solicitar'){
        if(!empty($_POST['nomeSolicitante']) || !empty($_POST['emailSolicitante']) || !empty($_POST['celularSolicitante']) || !empty($_POST['descSolicitante'])){

            $nomeSolicitante = $_POST['nomeSolicitante'];
            $emailSolicitante = $_POST['emailSolicitante'];
            $celularSolicitante = $_POST["celularSolicitante"];
            $descSolicitante = $_POST["descSolicitante"];
            
            try{
                $Comando = $conexao->prepare("INSERT INTO solicitacoes(nomeSolicitante, emailSolicitante, celularSolicitante, descSolicitante, idProf) VALUES (?,?,?,?,?)");

                $Comando-> bindParam(1, $nomeSolicitante);
                $Comando-> bindParam(2, $emailSolicitante);
                $Comando-> bindParam(3, $celularSolicitante);
                $Comando-> bindParam(4, $descSolicitante);
                $Comando-> bindParam(5, $pegaID);
            
                if($Comando->execute()){
        
                    if($Comando->rowCount()>0){
                        echo "<script>Swal.fire({position: 'center', type: 'success', title: 'Solicitação enviada com sucesso!', text: 'Em breve o profissional entrará em contato com você.', showConfirmButton: false, timer: 4000})</script>";
                    }
                    else{
                        echo "<script>Swal.fire({ type: 'error', title: 'Houve um erro, por favor tente novamente!', showConfirmButton: false, timer: 2000})</script>";
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
            echo "<script>Swal.fire({ type: 'error', title: 'Por favor preencha o todos os campos!', showConfirmButton: false, timer: 2000})</script>";
        }
    }
?>
<div clas="container" style="padding: 50px;">
    <div class="row justify-content-center">
        <h1 style="margin-bottom: 60px;"><?=$nome?></h1>
    </div>
    <div class="row">
        <div class="container col-md-7">
            <h2>Dados do Profissional</h2>
            <label><strong>Nome do Profissional</strong></label>
            <input type="text" class="form-control" id="email_prof" placeholder="" value="<?=$nome?>" disabled style="border: none; background: white;"><br>
            <label><strong>Email do Profissional</strong></label>
            <input type="text" class="form-control" id="email_prof" placeholder="" value="<?=$email?>" disabled style="border: none; background: white;"><br>
            <label><strong>Tipo de Serviço</strong></label>
            <input type="text" class="form-control" id="email_prof" placeholder="" value="<?=$tipoServico?>" disabled style="border: none; background: white;"><br>
            <label><strong>Tipo de Serviço</strong></label>
            <textarea class="form-control" id="desc" name="descSolicitante" rows="5" disabled style="border: none; background: white;"><?=$descServico?></textarea><br>
        </div>
        <div class="container col-md-5">
            <form method="POST">
                <div class="container-fluid">
                    <h2>Faça sua solicitação</h2>
                    <label for="nome"><strong>Nome Comleto</label>
                    <input type="text" class="form-control" id="nome" placeholder="" name="nomeSolicitante" required maxlength="20"><br>
                    <label for="celular"><strong>Celular</label>
                    <input type="text" class="form-control" id="celular" placeholder="" name="celularSolicitante" required maxlength="20"><br>
                    <label for="email"><strong>Email</label>
                    <input type="email" class="form-control" id="email"  name="emailSolicitante" aria-describedby="emailHelp"><br>
                    <label for="desc"><strong>Digite aqui o que você precisa</label>
                    <textarea class="form-control" id="desc" name="descSolicitante" rows="3"></textarea><br>
                    <button type="button" id="modalSolicitacao" class="btn btn-warning col-md-12" style="margin-left: 5px;">Solicitar Prodissional</button>
                </div>
                <!-- MODAL -->
                <div class="modal" tabindex="-1" role="dialog" id="solicitar">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-body" style="padding-bottom: 0;">
                                <label>
                                    <h3><strong>Deseja confirmar a solicitação?</strong></p>
                                </label>
                                <div style="float: right;">
                                    <button id="fechamodal" type="button" class="btn btn-danger">Não</button>
                                    <button type="submit" name="botao" value="solicitar" class="btn btn-success">Sim</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $( "#modalSolicitacao" ).click(function() {
        $('#solicitar').modal('show');
    });
    $( "#fechamodal" ).click(function() {
        $('#solicitar').modal('hide');
    });
    $('#celular').mask('(00)00000-0000');
</script>