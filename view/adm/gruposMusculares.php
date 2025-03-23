<?php
   session_start();
    if( !isset($_SESSION["idAdm"])){
        header("location:../index.html");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../../utilitarios/loadNavbarAdm.js"></script>
    <script src="../../utilitarios/functionToggleNav.js"></script>
    <link rel="stylesheet" href="../../utilitarios/style.css">
    <title>Grupos Musculares</title>
</head>
<body class="body-principal">
<div id="navbar"></div>
    <!-- Conteúdo Principal -->
    <div id="main">
    <button class="btn-positive"  data-bs-toggle="modal" data-bs-target="#myModal">Adicionar Grupo Muscular</button>
        <div class="container mt-4">
            <h1 class="text-center">Grupos Musculares</h1>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Músculos Alvos</th>
                        <th>Opções</th>
                    </tr>
                </thead>
                <tbody id="tabelaGruposMusculares"></tbody>
            </table>
        </div>
    </div>

    <div class="modal" id="myModal" data-bs-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2>Adicionar Grupo Muscular</h2>
                    </div>
                    <div class="form-group">
                        <label for="nomeModal">Nome do Grupo Muscular:</label>
                        <input name="nomeModal" id="nomeModal" class="form-control" placeholder="Informe o nome do Grupo Muscular" type="text">
                    </div>
                    <div class="modal-footer">
                        <button class="btn-positive" onclick="cadastrar()">Finalizar</button>
                        <button type="button" class="btn-negative" data-bs-dismiss="modal">Fechar</button>
                    </div>
                    </div>
                    </div>
                </div>
            </div>
            <!-- Modal Alterar -->
<div class="modal" id="modalAlterar" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Alterar Grupo Muscular</h2>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="nomeAlterar">Nome do Grupo Muscular:</label>
                    <input name="nomeAlterar" id="nomeAlterar" class="form-control" type="text">
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-positive" id="btnSalvarAlteracao">Salvar</button>
                <button class="btn-negative" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Excluir -->
<div class="modal" id="modalExcluir" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Excluir Grupo Muscular</h2>
            </div>
            <div class="modal-body">
                <p>Tem certeza de que deseja excluir o grupo muscular <strong id="nomeExcluir"></strong>?</p>
            </div>
            <div class="modal-footer">
                <button class="btn-positive" id="btnConfirmarExclusao">Excluir</button>
                <button class="btn-neutral" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

    <script src="../../utilitarios/jquery-3.7.1.min.js"></script>
    <script>
        var idAdm;
        $(document).ready(function() {
            var idAdm = <?php echo json_encode($_SESSION["idAdm"]); ?>;
            pegarPorId(idAdm);
            pegarTodos();
        });

        function pegarPorId(idAdm) {
                $.ajax({
                    url: "../../controle/admControle.php",
                    type: "POST",
                    data: {
                        acao: "pegarPorId",
                        idAdm: idAdm
                    },
                    success: function(retorno) {
                        if (Array.isArray(retorno) && retorno.length > 0) {
                            var adm = retorno[0];
                            document.getElementById("nomeUsuario").innerText = adm.nome;
                        } else {
                            console.error('Nenhum dado foi retornado.');
                        }
                    },
                    error: function(error) {
                        console.error('Erro ao carregar dados do praticante:', error);
                    }
                });
            }

            function pegarTodos() {
                $.ajax({
                    url: "../../controle/grupoMuscularControle.php",
                    type: "POST",
                    data: { acao: "pegarTodos" },
                    success: function(retorno) {
                        var result = JSON.parse(retorno);
                        if (Array.isArray(result) && result.length > 0) {
                            var tabelaBody = document.getElementById("tabelaGruposMusculares");
                            tabelaBody.innerHTML = "";

                            result.forEach(function(item) {
                                var tr = document.createElement("tr");

                                // Nome do Grupo Muscular
                                var tdNome = document.createElement("td");
                                tdNome.innerText = item.nomeGrupoMuscular;
                                tr.appendChild(tdNome);

                                // Músculos Alvo
                                var tdMusculos = document.createElement("td");
                                tdMusculos.innerText = item.musculosAlvo;
                                tr.appendChild(tdMusculos);

                                // Botões de Ação
                                var tdButton = document.createElement("td");

                                // Botão Alterar
                                var btnAlterar = document.createElement("button");
                                btnAlterar.innerText = "Alterar";
                                btnAlterar.className = "btn-neutral";
                                btnAlterar.onclick = function() {
                                    abrirModalAlterar(item.idGrupoMuscular, item.nomeGrupoMuscular);
                                };
                                tdButton.appendChild(btnAlterar);

                                // Botão Excluir
                                var btnExcluir = document.createElement("button");
                                btnExcluir.innerText = "Excluir";
                                btnExcluir.className = "btn-negative";
                                btnExcluir.onclick = function() {
                                    abrirModalExcluir(item.idGrupoMuscular, item.nomeGrupoMuscular);
                                };
                                tdButton.appendChild(btnExcluir);

                                tr.appendChild(tdButton);
                                tabelaBody.appendChild(tr);
                            });
                        } else {
                            console.error("Nenhum dado foi retornado.");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Erro ao buscar dados: ", error);
                    }
                });
            }


            function abrirModalAlterar(idGrupoMuscular, nomeGrupoMuscular) {
                // Preenche o campo do nome no modal
                $("#nomeAlterar").val(nomeGrupoMuscular);

                // Configura o botão Salvar para passar o ID do grupo muscular
                $("#btnSalvarAlteracao").off("click").on("click", function() {
                    salvarAlteracao(idGrupoMuscular);
                });

                // Mostra o modal
                $("#modalAlterar").modal("show");
            }



            function abrirModalExcluir(idGrupoMuscular, nomeGrupoMuscular) {
                // Preenche o nome do grupo muscular no modal
                $("#nomeExcluir").text(nomeGrupoMuscular);

                // Configura o botão Excluir para passar o ID do grupo muscular
                $("#btnConfirmarExclusao").off("click").on("click", function() {
                    confirmarExclusao(idGrupoMuscular);
                });

                // Mostra o modal
                $("#modalExcluir").modal("show");
            }


            function salvarAlteracao(idGrupoMuscular) {
                var nomeAlterar = $("#nomeAlterar").val();
                console.log("Dados enviados:", {
                    acao: "alterar",
                    idGrupoMuscular: idGrupoMuscular,
                    nome: nomeAlterar
                });
               $.ajax({
                    url: "../../controle/grupoMuscularControle.php",
                    type: "POST",
                    data: {
                        acao: "alterar",
                        idGrupoMuscular: idGrupoMuscular,
                        nome: $("#nomeAlterar").val(),
                    },
                    success: function(retorno) {
                        $("#modalAlterar").modal("hide");
                        window.location.href = `alterarMusculosAlvos.php?idGrupoMuscular=${idGrupoMuscular}`;
                    },
                    error: function(xhr, status, error) {
                        console.error("Erro ao alterar exercício: ", error);
                    }
                });
            }

            function confirmarExclusao(idGrupoMuscular) {
                $.ajax({
                    url: "../../controle/grupoMuscularControle.php",
                    type: "POST",
                    data: { acao: "excluir", idGrupoMuscular: idGrupoMuscular },
                    success: function(retorno) {
                        $.ajax({
                            url: "../../controle/musculoAlvoControle.php",
                            type: "POST",
                            data: { acao: "excluir", idGrupoMuscular: idGrupoMuscular },
                            success: function(retorno) {
                                console.log(retorno);
                                alert("Grupo Muscular excluído com sucesso!");
                                $("#modalExcluir").modal("hide");
                                pegarTodos();
                            },
                            error: function(xhr, status, error) {
                                console.error("Erro ao excluir exercício: ", error);
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error("Erro ao excluir exercício: ", error);
                    }
                });
            }


            function cadastrar(){
                $.ajax({
                    url: "../../controle/grupoMuscularControle.php",
                    type: "POST",
                    data: {
                        acao: "cadastrar",
                        nome: $("#nomeModal").val(),
                    },
                    success: function(retorno){
                        window.location.href = "musculosAlvo.php";
                    }
                });
            }

</script>
</body>
    <!-- Bootstrap e Popper JS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</html>