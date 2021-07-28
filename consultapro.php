<!-- TABELA PROFISSIONAIS -->
<div id="consAtendimento" class="container" style="background: transparent; border:none; padding: 15px; font-family: 'Quicksand', sans-serif; color: black;">
    <div class="container">
        <div class="row justify-content-center">
            <h3> Lista de Profissionais </h3>
        </div>
        <div class="row justify-content-center">
            <div class="" style="border-bottom: rgb(66,218,250) solid; width: 100px; margin-top: 5px; margin-bottom: 30px;"></div>
        </div>
    </div>
    <div class="container">
        <table id="tabelaUsuarios" class="table table-light table-hover table-striped" style="">
            <thead>
                <tr>
                <th scope="col">Nome</th>
                <th scope="col">CPF</th>
                <th scope="col">Telefone/Celular</th>
                <th scope="col">Estado</th>
                </tr>
            </thead>
            <?php
                $selectUsuarios = "SELECT * FROM cad_profissional";
                

                $Matriz = $conexao->prepare($selectUsuarios);
                $Matriz->execute();
                
                while ($Linha = $Matriz->fetch(PDO::FETCH_OBJ)){
            ?>
                    <tr>
                        <td><a href="?page=gerenciar_profissional&id=<?=$Linha->idProf?>"><?=$Linha->nomeProf?></a></td>
                        <td><?=$Linha->cpfProf?>
                        <td><?=$Linha->telefoneProf. "\n" .$Linha->celularProf?>
                        <td><?=$Linha->ufProf?>
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
        $('#tabelaUsuarios').DataTable({
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