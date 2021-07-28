<html>
	<head>
		<!-- Mascaras -->
		<script>
			$('#cep_profissional').mask('00000-000');
			$('#cel_profissional').mask('(00)00000-0000');
			$('#cel2_profissional').mask('(00)00000-0000');
			$('#tel_profissional').mask('(00)0000-0000');
			$('#rg_profissional').mask('00.000.000-0');
			$('#cpf_profissional').mask('000.000.000-00');
			$('#uf_profissional').mask('AA');
		</script>
		<!-- BUSCA CEP -->
		<script type="text/javascript" >

			$(document).ready(function() {

			function limpa_formulário_cep() {
				// Limpa valores do formulário de cep.
				$("#rua_profissional").val("");
				$("#bairro_profissional").val("");
				$("#cidade_profissional").val("");
				$("#uf_profissional").val("");
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
						$("#uf_profissional").val("...");

						//Consulta o webservice viacep.com.br/
						$.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

							if (!("erro" in dados)) {
								//Atualiza os campos com os valores da consulta.
								$("#rua_profissional").val(dados.logradouro);
								$("#bairro_profissional").val(dados.bairro);
								$("#cidade_profissional").val(dados.localidade);
								$("#uf_profissional").val(dados.uf);
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
	<body>
	<?php 
		/* INCLUIR */
		if(isset($_POST['botao']) && $_POST['botao'] == 'incluir'){

			if(!empty($_POST['username']) || !empty($_POST['email']) || !empty($_POST['senha']) || !empty($_POST['senha2']) || !empty($_POST['nome']) || !empty($_POST['rg'])
				|| !empty($_POST['cpf']) || !empty($_POST['data_nascimento']) || !empty($_POST['estado_civil']) || !empty($_POST['sexo']) || !empty($_POST['cel1']) || !empty($_POST['cep'])
				|| !empty($_POST['endereco']) || !empty($_POST['numeroEnd']) || !empty($_POST['bairro']) || !empty($_POST['cidade']) || !empty($_POST['estadoEnd']) || !empty($_POST['descServico'])
				|| !empty($_POST['tipoServico'])){

				$username = $_POST['username'];
				$email = $_POST['email'];
				$senha = $_POST["senha"];
				$senha2 = $_POST["senha2"];
				$nome = $_POST["nome"];
				$rg = $_POST["rg"];
				$cpf = $_POST['cpf'];
				$data_nascimento = $_POST["data_nascimento"];
				$estado_civil = $_POST['estado_civil'];
				$sexo = $_POST['sexo'];
				$telefone = $_POST['telefone'];
				$cel1 = $_POST['cel1'];
				$cel2 = $_POST['cel2'];
				$cep = $_POST['cep'];
				$endereco = $_POST['endereco'];
				$numeroEnd = $_POST['numeroEnd'];
				$complementoEnd = $_POST['complementoEnd'];
				$bairroEnd = $_POST['bairro'];
				$cidadeEnd = $_POST['cidade'];
				$estadoEnd = $_POST['estadoEnd'];
				$descServico = $_POST['descServico'];
				$tipoServico = $_POST['tipoServico'];
				$ativo = 1;
				$mensalidade = 0;
				

				try {
					$Comando = $conexao->prepare("INSERT INTO cad_profissional(usuario, emailProf, senha, senha2, nomeProf, rgProf, 
					cpfProf, data_nascProf, estado_civilProf, sexoProf, telefoneProf, celularProf, celular2Prof, cepProf, ruaProf, numProf, compProf,
					bairroProf, cidadeProf, ufProf, ativo, mensalidade) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
	
					$Comando-> bindParam(1, $username);
					$Comando-> bindParam(2, $email);
					$Comando-> bindParam(3, $senha);
					$Comando-> bindParam(4, $senha2);
					$Comando-> bindParam(5, $nome);
					$Comando-> bindParam(6, $rg);
					$Comando-> bindParam(7, $cpf);
					$Comando-> bindParam(8, $data_nascimento);
					$Comando-> bindParam(9, $estado_civil);
					$Comando-> bindParam(10, $sexo);
					$Comando-> bindParam(11, $telefone);
					$Comando-> bindParam(12, $cel1);
					$Comando-> bindParam(13, $cel2);
					$Comando-> bindParam(14, $cep);
					$Comando-> bindParam(15, $endereco);
					$Comando-> bindParam(16, $numeroEnd);
					$Comando-> bindParam(17, $complementoEnd);
					$Comando-> bindParam(18, $bairroEnd);
					$Comando-> bindParam(19, $cidadeEnd);
					$Comando-> bindParam(20, $estadoEnd);
					$Comando-> bindParam(21, $ativo);
					$Comando-> bindParam(22, $mensalidade);
				
					if($Comando->execute()){
			
						if($Comando->rowCount()>0){
							
							try{
                                            
								$sql = "SELECT idProf FROM cad_profissional ORDER BY idProf DESC LIMIT 1";
								$Comando2 = $conexao->prepare($sql);
								$Comando2->execute();
								$Linha3 = $Comando2->fetch(PDO::FETCH_OBJ);
								$trazID = $Linha3->idProf;

								$sql = "INSERT INTO servicos(idProf, tipoServico, descServico) VALUES (?, ?, ?)";
								$query = $conexao->prepare($sql);
								$query-> bindParam(1, $trazID);
								$query-> bindParam(2, $tipoServico);
								$query-> bindParam(3, $descServico);
								$query->execute();
								
							
								if($query->rowCount()>0){
									echo "<script>Swal.fire({position: 'center', type: 'success', title: 'Cadastro efetuado com sucesso!', showConfirmButton: false, timer: 3000})</script>";
								}
								else{
									echo "<script>Swal.fire({ type: 'error', title: 'Não foi possível registrar o atendimento!', showConfirmButton: false, timer: 1500})</script>";
								}
							}
							catch(PDOException $erro){
								echo "<script>Swal.fire({ type: 'error', title: 'Não foi possível efetuar o cadastro!', showConfirmButton: false, timer: 1500})</script>";
							}
	
						}
						else{
							echo "<script>Swal.fire({ type: 'error', title: 'Não foi possível efetuar o cadastro!', showConfirmButton: false, timer: 1700})</script>";
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
				echo "<script>Swal.fire({ type: 'error', title: 'Por favor preencha os campos com * ao lado!', showConfirmButton: false, timer: 1700})</script>";
			}
		}
	?>
	<form method="POST" action="">
		<div class="container" style="padding: 50px;">
			<div class="container">
				<h1 id="cadastro-titulo">Cadastro de Profissional</h1>
			</div>
			<div class="container col-md-10 offset-md-1" id="cadProfissionais">
				<div class="row">
					<h4 style="border-bottom: 2px solid #58bbc9;">Dados de Acesso</h4>
				</div>
				<div class="row">
					<div class="form-group col-md-6">
						<label for="user">Usuário*</label>
						<input type="text" class="form-control" id="user" placeholder="" name="username" required maxlength="20">
					</div>
					<div class="form-group col-md-6">
						<label for="email">Email*</label>
						<input type="text" class="form-control" id="email" placeholder="" name="email" required maxlength="50">
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-6">
						<label for="senha">Senha*</label>
						<input type="password" class="form-control" id="senha" placeholder="" name="senha" required maxlength="20">
					</div>
					<div class="form-group col-md-6">
						<label for="repeat_senha">Repita Senha*</label>
						<input type="password" class="form-control" id="repeat_senha" placeholder="" name="senha2" required maxlength="20">
					</div>
				</div><hr />
				<div class="row">
					<h4 style="border-bottom: 2px solid #58bbc9;">Dados Pessoais</h4>
				</div>
				<div class="row">
					<div class="form-group col-md-4">
						<label for="nome">Nome Completo*</label>
						<input type="text" class="form-control" id="nome" placeholder="" name="nome" required maxlength="70">
					</div>
					<div class="form-group col-md-4">
						<label for="rg">RG*</label>
						<input type="text" class="form-control" id="rg_profissional" placeholder="" name="rg" required maxlength="12">
					</div>
					<div class="form-group col-md-4">
						<label for="nome">CPF*</label>
						<input type="text" class="form-control" id="cpf_profissional" placeholder="" name="cpf" required maxlength="14">
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4">
						<label for="rg">Data de Nascimento*</label>
						<input type="date" class="form-control" id="rg" placeholder="" name="data_nascimento" required maxlength="10">
					</div>
					<div class="form-group col-md-4">
						<label for="estado_civil">Estado Civil*</label>
						<select id="estado_civil" class="form-control" name="estado_civil">
							<option selected>Selecione</option>
							<option value="solteiro">Solteiro(a)</option>
							<option value="casado">Casado(a)</option>
							<option value="separado">Separado(a)</option>
							<option value="divorciado">Divorciado(a)</option>
							<option value="viuco">Viúvo(a)</option>
						</select>
					</div>
					<div class="form-group col-md-4">
						<label for="estado_civil">Sexo*</label>
						<select id="sexo" class="form-control" name="sexo">
							<option selected>Selecione</option>
							<option value="M">Masculino</option>
							<option value="F">Feminino</option>
							<option value="O">Outro</option>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-4">
						<label for="telefone_fixo">Telefone Fixo</label>
						<input type="text" class="form-control" id="tel_profissional" placeholder="" name="telefone" maxlength="14">
					</div>
					<div class="form-group col-md-4">
						<label for="celular">Celular*</label>
						<input type="text" class="form-control" id="cel_profissional" placeholder="" name="cel1" required maxlength="15">
					</div>
					<div class="form-group col-md-4">
						<label for="celular_2">Celular 2</label>
						<input type="text" class="form-control" id="cel2_profissional" placeholder="" name="cel2" maxlength="15">
					</div>
				</div><hr />
				<div class="row">
					<h4 style="border-bottom: 2px solid #58bbc9;">Endereço</h4>
				</div>
				<div class="row">
					<div class="form-group col-md-3">
						<label for="nome">CEP*</label>
						<input type="text" class="form-control" id="cep_profissional" placeholder="" name="cep" required maxlength="9">
					</div>
					<div class="form-group col-md-6">
						<label for="rg">Endereço*</label>
						<input type="text" class="form-control" id="rua_profissional" placeholder="" name="endereco" required maxlength="50">
					</div>
					<div class="form-group col-md-3">
						<label for="nome">Número*</label>
						<input type="text" class="form-control" id="nome" placeholder="" name="numeroEnd" required maxlength="5">
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-3">
						<label for="complemento">Complemento</label>
						<input type="text" class="form-control" id="complemento" placeholder="" name="complementoEnd" maxlength="20">
					</div>
					<div class="form-group col-md-3">
						<label for="rg">Bairro*</label>
						<input type="text" class="form-control" id="bairro_profissional" name="bairro" placeholder="" required maxlength="30">
					</div>
					<div class="form-group col-md-4">
						<label for="rg">Cidade*</label>
						<input type="text" class="form-control" id="cidade_profissional" name="cidade" placeholder="" required maxlength="50">
					</div>
					<div class="form-group col-md-2">
						<label for="nome">Estado / UF*</label>
						<input type="text" class="form-control" id="uf_profissional" placeholder="" name="estadoEnd" required maxlength="2">
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
                            <option value="<?=$Linha->servico?>"><?=$Linha->servico?></option>
                        <?php
                            }
                        ?>
                        </select>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-12">
						<label for="descServico">Descrição do Serviço</label>
    					<textarea class="form-control" id="descServico" rows="5" name="descServico"></textarea>
					</div>
				</div><hr />

				<!--  ANTECEDENTES CRIMINAIS E COMPROVANTE DE RESIDENCIA
					<div class="row">
						<h4 style="border-bottom: 2px solid rgb(254, 116, 0);">Documentos</h4>
					</div>
					<div class="row">
						<div class="form-group col-md-6">
							<label for="comprovante_residencia">Comprovante de Residência*</label>
							<div class="custom-file" id="comprovante_residencia">
								<input type="file" class="custom-file-input" id="validatedCustomFile">
								<label class="custom-file-label" for="validatedCustomFile">Insira o arquivo...</label>
								<div class="invalid-feedback">Por favor insira um documento pdf, jpg, ou jpeg.</div>
							</div>
						</div>
						<div class="form-group col-md-6">
							<label for="comprovante_residencia">Antecedentes Criminais*</label>
							<div class="custom-file" id="comprovante_residencia">
								<input type="file" class="custom-file-input" id="validated_residencia">
								<label class="custom-file-label" for="validatedCustomFile">Insira o arquivo...</label>
								<div class="invalid-feedback">Por favor insira um documento pdf, jpg, ou jpeg.</div>
							</div>
						</div>
					</div><hr />
				-->
				
				<div class="row">
					<div class="form-check">
						<input type="checkbox" class="form-check-input" id="customCheck1" required>
						<label class="form-check-label" for="customCheck1">Li e aceito as <a href="#">normas e termos de uso</a> do site.</label>
					</div>
				</div><br>
				<div class="row">
					<button name="botao" value="incluir" type="submit" class="btn btn-outline-primary col-md-3 offset-9">Concluir</button>
				</div>
			</div>
		</div>
	</form>
		<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	</body>

</html>