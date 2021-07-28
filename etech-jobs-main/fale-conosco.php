<script>
    $('#celularContato').mask('(00)00000-0000');
</script>

<?php
    /* INCLUIR */
    if(isset($_POST['botao']) && $_POST['botao'] == 'incluir'){
        if(!empty($_POST['nomeContato']) || !empty($_POST['emailContato']) || !empty($_POST['celularContato']) || !empty($_POST['descricaoContato']) || !empty($_POST['tipoContato'])){

            $nomeContato = $_POST['nomeContato'];
            $emailContato = $_POST['emailContato'];
            $celularContato = $_POST["celularContato"];
            $descricaoContato = $_POST["descricaoContato"];
            $tipoContato = $_POST['tipoContato'];
            $statusContato = $_POST['statusContato'];
            $dataContato = date("Y-m-d");
            
            try{
                $Comando = $conexao->prepare("INSERT INTO contato(nomeContato, emailContato, celularContato, descricaoContato, tipoContato, statusContato, dataContato) VALUES (?,?,?,?,?,?,?)" );

                $Comando-> bindParam(1, $nomeContato);
                $Comando-> bindParam(2, $emailContato);
                $Comando-> bindParam(3, $celularContato);
                $Comando-> bindParam(4, $descricaoContato);
                $Comando-> bindParam(5, $tipoContato);
                $Comando-> bindParam(6, $statusContato);
                $Comando-> bindParam(7, $dataContato);
            
                if($Comando->execute()){
        
                    if($Comando->rowCount()>0){
                        echo "<script>Swal.fire({position: 'center', type: 'success', title: 'Sugestão / Critica enviada com sucesso!', showConfirmButton: false, timer: 2000})</script>";
                    }
                    else{
                        echo "<script>Swal.fire({ type: 'error', title: 'Não foi possível enviar a requisição!', showConfirmButton: false, timer: 2000})</script>";
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



<div class="container" style="padding: 50px;">
    <div class="row justify-content-center">
        <h2>Fale Conosco</h2>
    </div>
    <div class="row justify-content-center">
        <div class="" style="border-bottom: rgb(66,218,250) solid; width: 100px; margin-top: 5px; margin-bottom: 30px;"></div>
    </div>
    <div class="row justify-content-center">
        <h5>Insira as informações abaixo, para enviar sua sugestão / crítica.</h5>
    </div>
    <div class="row col-md-12" style="margin-top: 50px;">
        <form class="form-inline col-md-12" method="POST">
            <div class="form-row col-md-4">
                <div class="form-group col-md-12">
                    <label for="nomeContato"><h5>Nome Completo:</h5></label>
                    <input type="text" class="form-control col-md-10" id="nomeContato" name="nomeContato">
                    <label for="emailContato"><h5>Digite seu Email:</h5></label>
                    <input type="email" class="form-control col-md-10" id="emailContato" name="emailContato">
                    <label for="celularContato"><h5>Celular:</h5></label>
                    <input type="text" class="form-control col-md-10" id="celularContato" name="celularContato">
                    <label for="tipoContato"><h5>Tipo de Contato</h5></label>
                    <select name="tipoContato" class="form-control col-md-10">
                        <option selected>Selecione</option>
                        <option value="Critica">Crítica</option>
                        <option value="Sugestao">Sugestão</option>
                        <option value="Outro">Outro</option>
                    </select>
                    <input value="Aberto" name="statusContato" hidden>
                </div>
            </div>
            <div class="col-md-8">
                <div class="row">
                    <h4>Deixe aqui sua sugestão / critica.</h4>
                </div>
                <div class="row">
                    <textarea class="form-control col-md-12" id="descServico" rows="10" name="descricaoContato"></textarea>
                </div>
            </div>
            <div class="col-md-12" style="margin-top: 25px;">
                <div class="row" style="float: right;">
                    <button type="submit" name="botao" value="incluir" class="btn btn-warning col-md-12" style="margin-left: 5px;">Enviar</button>
                </div>
            </div>
        </form>
    </div>
</div>