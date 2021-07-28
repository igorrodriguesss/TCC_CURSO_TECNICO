<?php
	$pagina = (!isset($_GET['pagina']))? 1 : $_GET['pagina'];
	
	$sqlExec = $conexao->prepare("SELECT idservico FROM servicos");
	$sqlExec->execute();
	$result = $sqlExec->fetchAll();

	$exibir = 12; //ESTE NUMERO CONTROLA O NUMERO DE CARDS NA TELA

	$total = ceil((count($result)/$exibir));

	
	$inicioExibir = ($exibir * $pagina) - $exibir; //CASO N TENHA PAGINA NA URL ELE INCIA NA PAGINA 1

	$sql = "SELECT cad_profissional.idProf, servicos.idservico, servicos.tipoServico, servicos.descServico, cad_profissional.nomeProf FROM cad_profissional INNER JOIN servicos ON cad_profissional.idProf = servicos.idProf WHERE servicos.tipoServico = '" .$_GET['tds']. "' AND cad_profissional.mensalidade = 1 ORDER BY servicos.idservico DESC LIMIT $inicioExibir, $exibir";
    
	$sqlExec1 = $conexao->prepare($sql);
	$sqlExec1->execute();
	$result1 = $sqlExec1->fetchAll();
	
	if($sqlExec->rowCount() > 0){
?>
		<div class="container-fluid">
			<div class="row">
				<div class="card col-md-12" style="border: none; padding: 0;">
					<a class="duvida" data-toggle="collapse" href="#collapseExample2" role="button" aria-expanded="false" aria-controls="collapseExample">
						<div class="card-header" style=" background: rgb(23,49,62); color: white; border-radius: 0;">
							<div class="row justify-content-center">
								<h4>Categorias de Serviços</h4>
							</div>
						</div>
					</a>
					<div class="collapse" id="collapseExample2">
						<div class="card card-body">
							<div class="row justify-content-center">
								<div class="col-md-3" style="padding: 5px 15px 5px 15px;">
									<ul><p style="font-size: 1.36rem;">Advocacia</p></ul><hr />
									<ul><a href="index.php?p=servicos&tds=Analise Documental" class="item-menu" style="color: black;">Analise Documental</a></ul>
									<ul><a href="index.php?p=servicos&tds=Analise Contratual" class="item-menu" style="color: black;">Analise Contratual</a></ul>
									<ul><a href="index.php?p=servicos&tds=Consultoria Juridica" class="item-menu" style="color: black;">Consultoria Juridica</a></ul>
								</div>
								<div class="col-md-3" style="border-left: 1px whitesmoke outset; padding: 5px 15px 5px 15px;">
									<ul><p style="font-size: 1.36rem; ">T.I</p></ul><hr />
									<ul><a href="index.php?p=servicos&tds=Analista de Sistemas" class="item-menu" style="color: black;">Analise de Banco de Dados</a></ul>
									<ul><a href="index.php?p=servicos&tds=Desenvolvimento de Sistemas" class="item-menu" style="color: black;">Desenvolvimento de Sistemas</a></ul>
									<ul><a href="index.php?p=servicos&tds=Segurança da Informação" class="item-menu" style="color: black;">Segurança da Informação</a></ul>
								</div>
								<div class="col-md-3" style="border-left: 1px whitesmoke outset; padding: 5px 15px 5px 15px;">
									<ul><p style="font-size: 1.36rem;">Financeiro</p></ul><hr />
									<ul><a href="index.php?p=servicos&tds=Auditoria de Gastos" class="item-menu" style="color: black;">Auditoria de Gastos</a></ul>
									<ul><a href="index.php?p=servicos&tds=Contabilidade" class="item-menu" style="color: black;">Contabilidade</a></ul>
									<ul><a href="index.php?p=servicos&tds=Planejamento financeiro" class="item-menu" style="color: black;">Planejamento financeiro</a></ul>
								</div>
								<div class="col-md-3" style="border-left: 1px whitesmoke outset; padding: 5px 15px 5px 15px;">
									<ul><p style="font-size: 1.36rem;">Serviços Domésticos</p></ul><hr />
									<ul><a href="index.php?p=servicos&tds=Caseiros" class="item-menu" style="color: black;">Caseiros</a></ul>
									<ul><a href="index.php?p=servicos&tds=Limpeza" class="item-menu" style="color: black;">Limpeza</a></ul>
									<ul><a href="index.php?p=servicos&tds=Consertos em Geral" class="item-menu" style="color: black;">Consertos em Geral</a></ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container" style="padding: 0 0 50px 0;">
			<div class="row justify-content-center">
				<?php
				for($i = 0; $i < count($result1); $i++){
				?>
					<div class="card col-md-3" style="padding: 0; display: inline-block; margin: 15px 50px 15px 0;">
						<div class="card-header">
							<strong><?=$result1[$i][4]?></strong>
						</div>
						<div class="card-body">
							<h5 class="card-title"><?=$result1[$i][2]?></h5>
							<textarea class="col-md-12" rows='6' style="overflow: auto; border: hidden;" readonly><?=$result1[$i][3]?></textarea><br>
							<a href="?p=profissional&cod=<?=$result1[$i][0]?>" class="btn btn-primary" style="color: white;">Visitar</a>
						</div>
					</div>
				<?php 
				}
				?>
			</div>
			<div class="row justify-content-center" style="margin-top: 25px;">
				<nav aria-label="Navegação de página exemplo">
					<ul class="pagination">
						<?php 
							$desabilita = "?p=servicos&tds=". $_GET['tds']. "&pagina=" . (intval($pagina)-1);
							if($pagina == 1 || !isset($_GET['pagina'])){
								$desabilita = "";
							}
						?>
						<li class="page-item"><a class="page-link" href="<?=$desabilita?>">Anterior</a></li>
					<?php
					for($i = 1; $i <= $total; $i++){
						if($i != $pagina){ ?>
							<li class="page-item"><a class="page-link" href='?p=servicos&tds=<?=$_GET['tds']?>&pagina=<?=$i?>'><?=$i?></a></li>
					<?php
						}else{ ?>
							<li class="page-item"><a class="page-link" href='?p=servicos&tds=<?=$_GET['tds']?>&pagina=<?=$i?>'><?=$i?></a></li>
					<?php
						}
					}
					$desabilita = "?p=servicos&tds=". $_GET['tds']. "&pagina=" . (intval($pagina)+1);
					if($pagina >= $total){
							$desabilita = "";
					}
					?>
						<li class="page-item"><a class="page-link" href="<?=$desabilita?>">Próximo</a></li>
					</ul>
				</nav>
			</div>
		</div>
	<?php
	}
	?>