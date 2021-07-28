<script>
    $('#nCartao').mask('0000 0000 0000 0000');
    $('#vCartao').mask('00/0000');
    $('#cvv').mask('0000');
</script>
<?php
    $pegaID = $_SESSION['usuarioId'];
    $sql = "SELECT mensalidade FROM cad_profissional WHERE idProf = $pegaID";
    $Matriz = $conexao->prepare($sql);
    $Matriz-> bindParam(1, $pegaID);
    $Matriz->execute();
    $Linha = $Matriz->fetch(PDO::FETCH_OBJ);
    $mensalidade = $Linha->mensalidade;
    
	if(!isset($_SESSION['logado']) || $_SESSION['logado'] != 1){
        echo '<script>window.location.href = "?p=login";</script>';
    }
    
    if($mensalidade != 0){
        echo '<script>window.location.href = "?p=meuperfil";</script>';
    }

    //SALVA AS ALTERAÇÕES
    if(isset($_POST['botao']) && $_POST['botao'] == 'pagar'){

        if(!empty($_POST['nTitular']) || !empty($_POST['nCartao']) || !empty($_POST['validade']) || !empty($_POST['cvv']) || !empty($_POST['tipo_cartao'])){
            
            $mensalidade = 1;
            $data_mensalidade = date("d/m/Y");
            $add_dia = strtotime("+1 Months");
            $data_expira_mensalidade = date("d/m/Y", $add_dia);

            try{
                $Comando = $conexao->prepare("UPDATE cad_profissional SET mensalidade=?, data_mensalidade=?, data_expira_mensalidade=? WHERE idProf = $pegaID");
                $Comando-> bindParam(1, $mensalidade);
                $Comando-> bindParam(2, $data_mensalidade);
                $Comando-> bindParam(3, $data_expira_mensalidade);
            
                if($Comando->execute()){

                    if($Comando->rowCount()>0){
                        echo "<script>Swal.fire({position: 'center', type: 'success', title: 'Pagamento realizado com sucesso!', showConfirmButton: false, timer: 1700})</script>";
                        echo ('<meta http-equiv="refresh"content=1;>');
                        
                    }
                    else{
                        echo "<script>Swal.fire({ type: 'error', title: 'Não foi possível efetuar o pagamento!', showConfirmButton: false, timer: 1700})</script>";
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
            echo "<script>Swal.fire({ type: 'error', title: 'Preencha todos os campos', showConfirmButton: false, timer: 1700})</script>";
        }
    }

?>

<div class="container" style="padding: 50px;">
    <div class="row justify-content-center">
        <h1 id="cadastro-titulo">Pagamento</h1>
    </div>
    <div class="row justify-content-center">
        <div class="" style="border-bottom: rgb(66,218,250) solid; width: 100px; margin-top: 5px; margin-bottom: 30px;"></div>
    </div>
    <div class="row justify-content-center">
        <div class="container col-md-5" style="background: whitesmoke; padding: 20px;">
            <form method="POST">
                <div class="container">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <h3>Cartão de Crédito</h3>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="nTitular">Nome do Titular:</label>
                            <input type="text" class="form-control" id="nTitular" placeholder="Nome como impresso no cartão" name="nTitular" required maxlength="20" value="" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="nCartao">Número do Cartão:</label>
                            <input type="text" class="form-control" id="nCartao" placeholder="0000 0000 0000 0000" name="nCartao" required maxlength="50" value="" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="validade">Validade (MM/AAAA):</label>
                            <input type="text" class="form-control" id="vCartao" placeholder="MM/AAAA" name="validade" required maxlength="50" value="" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="cvv">CVV:</label>
                            <input type="password" class="form-control" id="cvv" placeholder="3 ou 4 digítos" name="cvv" required maxlength="50" value="" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="om">Opções de Mensalidade:</label>
                            <select id="om" class="form-control">
                                <option value="1">1 mês: R$ 30,00</option>
                                <option value="3">3 meses: R$ 80,00</option>
                                <option value="6">6 meses: R$ 150,00</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <select id="estado_civil" class="form-control" name="estado_civil" value="" name="tipo_cartao" required>
                                <option value="american express">American Express</option>
                                <option value="elo">Elo</option>
                                <option value="mastercard">Mastercard</option>
                                <option value="visa">Visa</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6 offset-md-3">
                            <button class="btn btn-primary col-md-12" type="submit" name="botao" value="pagar">Pagar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>