<!-- TABELA ORÇAMENTOS -->
<div id="consSolicitacoes" class="container" style="background: transparent; border:none; padding: 50px; font-family: 'Quicksand', sans-serif; color: black;">
    <div class="container">
        <div class="row justify-content-center">
            <h1> Minhas Solicitações </h1>
        </div>
        <div class="row justify-content-center">
            <div class="" style="border-bottom: rgb(66,218,250) solid; width: 100px; margin-top: 5px; margin-bottom: 30px;"></div>
        </div>
    </div>

    <div class="container">
        <table id="tbSolicitacoes" class="table table-light table-hover table-striped" style="">
            <thead>
                <tr>
                <th scope="col">Nome</th>
                <th scope="col">Celular</th>
                <th scope="col">Email</th>
                <th scope="col">Descrição</th>
                </tr>
            </thead>
            <?php
                $pegaID = $_SESSION['usuarioId'];
                $selectSolicitacoes = "SELECT * FROM solicitacoes WHERE idProf = $pegaID";
                

                $Matriz = $conexao->prepare($selectSolicitacoes);
                $Matriz->execute();
                
                while ($Linha = $Matriz->fetch(PDO::FETCH_OBJ)){
            ?>
                    <tr>
                        <td><?=$Linha->nomeSolicitante?></td>
                        <td><?=$Linha->celularSolicitante?>
                        <td><?=$Linha->emailSolicitante?>
                        <td><?=$Linha->descSolicitante?>
                    </tr>
            <?php
                } 
            ?>
        </table>
    </div>
</div>

<!-- DATA TABLE -->
<script>
    $(document).ready( function () {
        $('#tbSolicitacoes').DataTable({
            'language': {
                "sEmptyTable": "Nenhum registro encontrado",
                "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                "sInfoPostFix": "",
                "sInfoThousands": ".",
                "sLengthMenu": "Resultados por página_MENU_",
                "sLoadingRecords": "Carregando...",
                "sProcessing": "Processando...",
                "sZeroRecords": "Nenhum registro encontrado",
                "sSearch": "Pesquisar",
                "oPaginate": {
                    "sNext": "Próximo",
                    "sPrevious": "Anterior",
                    "sFirst": "Primeiro",
                    "sLast": "Último"
                },
                "oAria": {
                    "sSortAscending": ": Ordenar colunas de forma ascendente",
                    "sSortDescending": ": Ordenar colunas de forma descendente"
                },
                "select": {
                    "rows": {
                        "_": "Selecionado %d linhas",
                        "0": "Nenhuma linha selecionada",
                        "1": "Selecionado 1 linha"
                    }
                }
            }
        });
    });
</script>