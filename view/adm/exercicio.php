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
    <title>Exercícios</title>
</head>
<body class="body-principal">
<div id="navbar"></div>
    <!-- Conteúdo Principal -->
    <div id="main">
    <div class="form-group">
            <label for="filtro">Filtrar Por Grupo Muscular:</label>
            <select onchange="filtrar(this.value)" class="form-control" name="filtro" id="filtro">
                <option value="0">Todos os Grupos Musculares</option>
            </select>
        </div>
    <button class="btn-positive"  data-bs-toggle="modal" data-bs-target="#myModal">Adicionar Exercício</button>
        <div class="container mt-4">
            <h1 class="text-center">Exercícios</h1>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th>Instrução</th>
                        <th>Grupo Muscular</th>
                        <th>Opções</th>
                    </tr>
                </thead>
                <tbody id="tabelaExercicios"></tbody>
            </table>
        </div>
    </div>

    <div class="modal" id="myModal" data-bs-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2>Adicionar Exercício</h2>
                    </div>
                    <div class="form-group">
                    <label for="nomeModal">Nome do Exercício:</label>
                    <input name="nomeModal" id="nomeModal" class="form-control" placeholder="Informe o nome" type="text">
                </div>
                <div class="form-group">
                    <label for="descricaoModal">Descrição sobre o Exercício:</label>
                    <textarea name="descricaoModal" id="descricaoModal" class="form-control" placeholder="Informe uma breve descrição" cols="10" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="instrucaoModal">Instrução sobre o Exercício:</label>
                    <textarea name="instrucaoModal" id="instrucaoModal" class="form-control" placeholder="Informe uma breve instrução" cols="10" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="grupo">Grupo Muscular:</label>
                    <select name="grupo" id="grupoMuscularModal" class="form-control">
                        <option value="0">Selecione</option>
                    </select>
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
                <h2>Alterar Exercício</h2>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="nomeAlterar">Nome do Exercício:</label>
                    <input name="nomeAlterar" id="nomeAlterar" class="form-control" type="text">
                </div>
                <div class="form-group">
                    <label for="descricaoAlterar">Descrição:</label>
                    <textarea name="descricaoAlterar" id="descricaoAlterar" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label for="instrucaoAlterar">Instrução:</label>
                    <textarea name="instrucaoAlterar" id="instrucaoAlterar" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label for="grupo">Grupo Muscular:</label>
                    <select name="grupo" id="grupoMuscularAlterar" class="form-control">
                        <option value="0">Selecione</option>
                    </select>
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
                <h2>Excluir Exercício</h2>
            </div>
            <div class="modal-body">
                <p>Tem certeza de que deseja excluir o exercício <strong id="nomeExcluir"></strong>?</p>
            </div>
            <div class="modal-footer">
                <button class="btn-positive" id="btnConfirmarExclusao">Excluir</button>
                <button class="btn-negative" data-bs-dismiss="modal">Cancelar</button>
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
                    url: "../../controle/exercicioControle.php",
                    type: "POST",
                    data: { acao: "pegarTodos" },
                    success: function(retorno) {
                        var result = JSON.parse(retorno);
                        if (Array.isArray(result) && result.length > 0) {
                            var tabelaBody = document.getElementById("tabelaExercicios");
                            tabelaBody.innerHTML = "";

                            result.forEach(function(item) {
                                var tr = document.createElement("tr");

                                var tdNome = document.createElement("td");
                                tdNome.innerText = item.nomeExercicio;
                                tr.appendChild(tdNome);

                                var tdDescricao = document.createElement("td");
                                tdDescricao.innerText = item.descricao;
                                tr.appendChild(tdDescricao);

                                var tdInstrucao = document.createElement("td");
                                tdInstrucao.innerText = item.instrucao;
                                tr.appendChild(tdInstrucao);

                                var tdGrupoMuscular = document.createElement("td");
                                tdGrupoMuscular.innerText = item.nomeGrupoMuscular;
                                tr.appendChild(tdGrupoMuscular);

                                var tdButton = document.createElement("td");

                                // Botão Alterar
                                var btnAlterar = document.createElement("button");
                                btnAlterar.innerText = "Alterar";
                                btnAlterar.className = "btn-neutral";
                                btnAlterar.onclick = function() {
                                    abrirModalAlterar(item);
                                };
                                tdButton.appendChild(btnAlterar);

                                // Botão Excluir
                                var btnExcluir = document.createElement("button");
                                btnExcluir.innerText = "Excluir";
                                btnExcluir.className = "btn-negative";
                                btnExcluir.onclick = function() {
                                    abrirModalExcluir(item);
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

                $.ajax({
                    url: "../../controle/grupoMuscularControle.php",
                    type: "POST",
                    data: {
                        acao: "pegarTodos",
                    },
                    success: function(retorno) {
                        result = JSON.parse(retorno);
                        if (Array.isArray(result)) {
                            result.forEach(function(item) {
                                $("#filtro").append(new Option(item.nomeGrupoMuscular, item.idGrupoMuscular));
                                $("#grupoMuscularModal").append(new Option(item.nomeGrupoMuscular, item.idGrupoMuscular));
                                $("#grupoMuscularAlterar").append(new Option(item.nomeGrupoMuscular, item.idGrupoMuscular));
                            });
                        } else {
                            console.error("Resposta não é um array:", result);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Erro ao buscar dados: ", error);
                    }
                });
            }

            function abrirModalAlterar(item) {
                // Preenche os campos do modal com os dados do exercício
                $("#nomeAlterar").val(item.nomeExercicio);
                $("#descricaoAlterar").val(item.descricao);
                $("#instrucaoAlterar").val(item.instrucao);
                $("#grupoMuscularAlterar").val(item.idGrupoMuscular); // Certifique-se de carregar os grupos musculares

                // Mostra o modal
                $("#modalAlterar").modal("show");

                // Configura o botão Salvar
                $("#btnSalvarAlteracao").off("click").on("click", function() {
                    salvarAlteracao(item.idExercicio);
                });
            }

            function abrirModalExcluir(item) {
                // Preenche o nome do exercício no modal
                $("#nomeExcluir").text(item.nomeExercicio);

                // Mostra o modal
                $("#modalExcluir").modal("show");

                // Configura o botão Excluir
                $("#btnConfirmarExclusao").off("click").on("click", function() {
                    confirmarExclusao(item.idExercicio);
                });
            }

            function salvarAlteracao(idExercicio) {
               $.ajax({
                    url: "../../controle/exercicioControle.php",
                    type: "POST",
                    data: {
                        acao: "alterar",
                        idExercicio: idExercicio,
                        nome: $("#nomeAlterar").val(),
                        descricao: $("#descricaoAlterar").val(),
                        instrucao: $("#instrucaoAlterar").val(),
                        grupoMuscular: $("#grupoMuscularAlterar").val()
                    },
                    success: function(retorno) {
                        alert("Exercício alterado com sucesso!");
                        $("#modalAlterar").modal("hide");
                        pegarTodos();
                    },
                    error: function(xhr, status, error) {
                        console.error("Erro ao alterar exercício: ", error);
                    }
                });
            }

            function confirmarExclusao(idExercicio) {
                $.ajax({
                    url: "../../controle/exercicioControle.php",
                    type: "POST",
                    data: { acao: "excluir", idExercicio: idExercicio },
                    success: function(retorno) {
                        alert("Exercício excluído com sucesso!");
                        $("#modalExcluir").modal("hide");
                        window.location.href = "exercicio.php";
                    },
                    error: function(xhr, status, error) {
                        console.error("Erro ao excluir exercício: ", error);
                    }
                });
            }


            function cadastrar(){
                $.ajax({
                    url: "../../controle/exercicioControle.php",
                    type: "POST",
                    data: {
                        acao: "cadastrar",
                        nome: $("#nomeModal").val(),
                        descricao: $("#descricaoModal").val(),
                        instrucao: $("#instrucaoModal").val(),
                        grupoMuscular: $("#grupoMuscularModal").val(),
                    },
                    success: function(retorno){
                        alert("Exercício Cadastrado com Sucesso!");
                        window.location.href = "exercicio.php";
                    }
                });
            }

            function filtrar(idGrupoMuscular) {
                // Verifica se o valor do select é "0"
                if (idGrupoMuscular === "0") {
                    pegarTodos();  // Chama a função pegarTodos caso seja "0"
                } else {
                    // Caso contrário, faz a filtragem
                    $.ajax({
                        url: "../../controle/exercicioControle.php",
                        type: "POST",
                        data: {
                            acao: "pegarTodosFiltro",
                            idGrupoMuscular: idGrupoMuscular
                        },
                        success: function(retorno) {
                            $('#tabelaExercicios').empty();
                            var result = JSON.parse(retorno);
                        if (Array.isArray(result) && result.length > 0) {
                            var tabelaBody = document.getElementById("tabelaExercicios");
                            tabelaBody.innerHTML = "";

                            result.forEach(function(item) {
                                var tr = document.createElement("tr");

                                var tdNome = document.createElement("td");
                                tdNome.innerText = item.nomeExercicio;
                                tr.appendChild(tdNome);

                                var tdDescricao = document.createElement("td");
                                tdDescricao.innerText = item.descricao;
                                tr.appendChild(tdDescricao);

                                var tdInstrucao = document.createElement("td");
                                tdInstrucao.innerText = item.instrucao;
                                tr.appendChild(tdInstrucao);

                                var tdGrupoMuscular = document.createElement("td");
                                tdGrupoMuscular.innerText = item.nomeGrupoMuscular;
                                tr.appendChild(tdGrupoMuscular);

                                var tdButton = document.createElement("td");

                                // Botão Alterar
                                var btnAlterar = document.createElement("button");
                                btnAlterar.innerText = "Alterar";
                                btnAlterar.className = "btn-neutral";
                                btnAlterar.onclick = function() {
                                    abrirModalAlterar(item);
                                };
                                tdButton.appendChild(btnAlterar);

                                // Botão Excluir
                                var btnExcluir = document.createElement("button");
                                btnExcluir.innerText = "Excluir";
                                btnExcluir.className = "btn-negative";
                                btnExcluir.onclick = function() {
                                    abrirModalExcluir(item);
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
            }

</script>
</body>
    <!-- Bootstrap e Popper JS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</html>