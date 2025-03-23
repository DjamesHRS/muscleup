<?php
    session_start();
    if( !isset($_SESSION["idPraticante"]) ){
        header("location:../index.html");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../../utilitarios/loadNavbar.js"></script>
    <script src="../../utilitarios/functionToggleNav.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../utilitarios/style.css">
    <title>Instrutores</title>
</head>
<body class="body-principal">
    <div id="navbar"></div>
    <!-- Conteúdo Principal -->
    <div id="main">
        <!-- Container para os cards -->
        <div class="container mt-4">
            <h1 class="text-center">Instrutores</h1>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Registro CREF</th>
                        <th>Data de Nascimento</th>
                        <th>Sexo</th>
                        <th>Data de Formação</th>
                        <th>Universidade de Formação</th>
                        <th>Descrição</th>
                    </tr>
                </thead>
                <tbody id="tabelaInstrutores" data-bs-toggle="modal" data-bs-target="#myModal"></tbody>
            </table>
        </div>

        <!-- Modal -->
        <div class="modal" id="myModal" data-bs-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 id="nomeInstrutor"></h1>
                    </div>
                    <div class="modal-body" id="modalBody"></div>
                    <div class="modal-footer">
                        <button class="btn-negative" type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../../utilitarios/jquery-3.7.1.min.js"></script>
    <script>
        var idPraticante;
        $(document).ready(function() {
            // Define idPraticante e chama a função pegarPorId
            var idPraticante = <?php echo json_encode($_SESSION["idPraticante"]); ?>;
            pegarPorId(idPraticante);
            pegarTodos();
        });

        function pegarPorId(idPraticante) {
            $.ajax({
                url: "../../controle/praticanteControle.php",
                type: "POST",
                data: {
                    acao: "pegarPorId",
                    idPraticante: idPraticante
                },
                success: function(retorno) {
                    if (Array.isArray(retorno) && retorno.length > 0) {
                        var praticante = retorno[0];  // Pega o primeiro objeto
                        document.getElementById("nomeUsuario").innerText = praticante.nome;
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
                url: "../../controle/instrutorControle.php",
                type: "POST",
                data: {
                    acao: "pegarTodos",
                },
                success: function(retorno) {
                    var result = JSON.parse(retorno);
                    
                    if (Array.isArray(result) && result.length > 0) {
                        var tabelaBody = document.getElementById("tabelaInstrutores");
                        var modalBody = document.getElementById("modalBody");
                        var nomeInstrutor = document.getElementById("nomeInstrutor");
                        tabelaBody.innerHTML = "";

                        result.forEach(function(item) {
                            // Cria uma nova linha de dados na tabela
                            var tr = document.createElement("tr");

                            // Adiciona as células para cada coluna da tabela
                            var tdNome = document.createElement("td");
                            tdNome.innerText = item.nome;
                            tr.appendChild(tdNome);

                            var tdCref = document.createElement("td");
                            tdCref.innerText = item.cref;
                            tr.appendChild(tdCref);

                            var tdDataNascimento = document.createElement("td");
                            tdDataNascimento.innerText = item.dataDeNascimento;
                            tr.appendChild(tdDataNascimento);

                            var tdSexo = document.createElement("td");
                            tdSexo.innerText = item.sexo;
                            tr.appendChild(tdSexo);

                            var tdDataFormacao = document.createElement("td");
                            tdDataFormacao.innerText = item.dataDeFormacao;
                            tr.appendChild(tdDataFormacao);

                            var tdUniversidade = document.createElement("td");
                            tdUniversidade.innerText = item.universidadeDeFormacao;
                            tr.appendChild(tdUniversidade);

                            var tdDescricao = document.createElement("td");
                            tdDescricao.innerText = item.descricao;
                            tr.appendChild(tdDescricao);

                            // Adiciona a nova linha na tabela
                            tabelaBody.appendChild(tr);

                            // Adiciona evento de clique na linha
                            tr.addEventListener("click", function() {
                                // Exibe os dados no modal
                                nomeInstrutor.innerText = item.nome;

                                modalBody.innerHTML = `
                                    <p><strong>Registro CREF:</strong> ${item.cref}</p>
                                    <p><strong>Data de Nascimento:</strong> ${item.dataDeNascimento}</p>
                                    <p><strong>Sexo:</strong> ${item.sexo}</p>
                                    <p><strong>Data de Formação:</strong> ${item.dataDeFormacao}</p>
                                    <p><strong>Universidade de Formação:</strong> ${item.universidadeDeFormacao}</p>
                                    <p><strong>Descrição:</strong> ${item.descricao}</p>
                                `;
                            });
                        });
                    } else {
                        console.error('Nenhum dado foi retornado.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Erro ao buscar dados: ", error);
                }
            });
        }
    </script>

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
