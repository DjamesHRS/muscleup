<?php
    session_start();
    if( !isset($_SESSION["idInstrutor"]) ){
        header("location:../index.html");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../../utilitarios/loadNavbarInstrutor.js"></script>
    <script src="../../utilitarios/functionToggleNav.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
        <!-- Container para os cards -->
        <div class="container mt-4">
            <h1 class="text-center">Exercícios</h1>
            <div class="row" id="todos-exercicios">
                <!-- Cards serão injetados aqui via AJAX -->
            </div>
        </div>
    </div>

    <script src="../../utilitarios/jquery-3.7.1.min.js"></script>
    <script>
        var idInstrutor;
        $(document).ready(function() {
            var idInstrutor = <?php echo json_encode($_SESSION["idInstrutor"]); ?>;
            pegarPorId(idInstrutor);
            pegarTodos();
        });

        function pegarPorId(idInstrutor) {
                $.ajax({
                    url: "../../controle/instrutorControle.php",
                    type: "POST",
                    data: {
                        acao: "pegarPorId",
                        idInstrutor: idInstrutor
                    },
                    success: function(retorno) {
                        if (Array.isArray(retorno) && retorno.length > 0) {
                            var instrutor = retorno[0];  // Pega o primeiro objeto
                            document.getElementById("nomeUsuario").innerText = instrutor.nome;
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
                    data: {
                        acao: "pegarTodos",
                    },
                    success: function(retorno) {
                        var result = JSON.parse(retorno);
                    
                        if (Array.isArray(result) && result.length > 0) {
                            result.forEach(function(item) {
                                // Cria um card com as informações de nome, descricao e instrucao
                                var cardHtml = `
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">${item.nomeExercicio}</h5>
                                            <p class="card-text"><strong>Descrição:</strong> ${item.descricao}</p>
                                            <p class="card-text"><strong>Instrução:</strong> ${item.instrucao}</p>
                                            <p class="card-text"><strong>Grupo Muscular:</strong> ${item.nomeGrupoMuscular}</p>
                                        </div>
                                    </div>
                                `;

                                // Adiciona o card diretamente na página (sem verificação de status)
                                $('#todos-exercicios').append(cardHtml);
                            });
                        } else {
                            console.error('Nenhum dado foi retornado.');
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
                        //console.log(result);
                        if (Array.isArray(result)) {
                            result.forEach(function(item) {
                                $("#filtro").append(new Option(item.nomeGrupoMuscular, item.idGrupoMuscular));
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
                            $('#todos-exercicios').empty();
                            var result = JSON.parse(retorno);
                            
                            if (Array.isArray(result) && result.length > 0) {
                                result.forEach(function(item) {
                                    // Cria um card com as informações de nome, descricao e instrucao
                                    var cardHtml = `
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title">${item.nomeExercicio}</h5>
                                                <p class="card-text"><strong>Descrição:</strong> ${item.descricao}</p>
                                                <p class="card-text"><strong>Instrução:</strong> ${item.instrucao}</p>
                                                <p class="card-text"><strong>Grupo Muscular:</strong> ${item.nomeGrupoMuscular}</p>
                                            </div>
                                        </div>
                                    `;
                                    // Adiciona o card diretamente na página
                                    $('#todos-exercicios').append(cardHtml);
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
            }


    </script>
<!-- Latest compiled JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
