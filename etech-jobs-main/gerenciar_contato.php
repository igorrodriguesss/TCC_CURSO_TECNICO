<?php
    if(!isset($_SESSION['logadoWeb']) || $_SESSION['logadoWeb'] != 1){
        echo '<script>window.location.href = "admin.php";</script>';
    }

    function selected( $value, $selected ){
        return $value==$selected ? ' selected="selected"' : '';
    }


    $pegaID = $_GET['id'];
    $sql = "SELECT * FROM contato WHERE idContato = $pegaID ";
        
    $tipoContato = "";
    $descricaoContato = "";
    $nomeContato = "";
    $emailContato = "";
    $celularContato = "";
    $statusContato = "";

    if(isset($pegaID) && $pegaID != 0 || $pegaID != "" || $pegaID != NULL){
        $Matriz2 = $conexao->prepare($sql);
        $Matriz2-> bindParam(1, $pegaID);
        $Matriz2->execute();
        $Linha2 = $Matriz2->fetch(PDO::FETCH_OBJ);
        $tipoContato = $Linha2->tipoContato;
        $descricaoContato = $Linha2->descricaoContato;
        $nomeContato = $Linha2->nomeContato;
        $emailContato = $Linha2->emailContato;
        $celularContato = $Linha2->celularContato;
        $statusContato = $Linha2->statusContato;
    }

    /* FECHA CONTATO */
    if(isset($_POST['botao']) && $_POST['botao'] == 'fechaContato'){
        $statusContato = 'Fechado';
        try{
            $Comando = $conexao->prepare("UPDATE contato SET statusContato=? WHERE idContato = $pegaID");
            $Comando-> bindParam(1, $statusContato);
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
?>

<div class="container">
    <div class="row justify-content-center">
        <h1 id="cadastro-titulo">Sugestões e Criticas</h1>
    </div>
    <div class="row justify-content-center">
        <div class="" style="border-bottom: rgb(66,218,250) solid; width: 100px; margin-top: 5px; margin-bottom: 30px;"></div>
    </div>
    <form class="form-inline col-md-12" method="POST">
        <div class="form-row col-md-4">
            <div class="form-group col-md-12">
                <label for="nomeContato"><h5>Nome Completo:</h5></label>
                <input type="text" class="form-control col-md-10" id="nomeContato" name="nomeContato" readonly value="<?=$nomeContato?>">
                <label for="emailContato"><h5>Digite seu Email:</h5></label>
                <input type="email" class="form-control col-md-10" id="emailContato" name="emailContato" readonly value="<?=$emailContato?>">
                <label for="celularContato"><h5>Celular:</h5></label>
                <input type="text" class="form-control col-md-10" id="celularContato" name="celularContato" readonly value="<?=$celularContato?>">
                <label for="tipoContato"><h5>Tipo de Contato</h5></label>
                <select name="tipoContato" class="form-control col-md-10" readonly>
                    <option selected>Selecione</option>
                    <option value="Critica" <?php echo selected( 'critica', $tipoContato ); ?>>Crítica</option>
                    <option value="Sugestao" <?php echo selected( 'sugestao', $tipoContato ); ?>>Sugestão</option>
                    <option value="Outro" <?php echo selected( 'outro', $tipoContato ); ?>>Outro</option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <h4 style="border-bottom: rgb(66,218,250) solid;">Sugestão / Critica.</h4>
            </div>
            <div class="row">
                <textarea class="form-control col-md-12" id="descServico" rows="10" name="descricaoContato" readonly><?=$descricaoContato?></textarea>
            </div>
        </div>
        <div class="col-md-12" style="margin-top: 25px;">
            <div class="row" style="float: right;">
                <button type="submit" name="botao" value="fechaContato" class="btn btn-warning col-md-12" style="margin-left: 5px;">Enviar</button>
            </div>
        </div>
    </form>
</div>