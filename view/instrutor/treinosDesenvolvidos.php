<?php
        session_start();
        if( !isset($_SESSION["idInstrutor"]) ){
            header("location:../index.html");
        }

        if (isset($_GET['idFichaDeTreino'])) {
            $idFichaDeTreino = $_GET['idFichaDeTreino'];
        } else {
            header("location:fichaDeTreino.php");
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
        <link rel="stylesheet" href="../../utilitarios/style.css">
        <title>Treinos</title>
    </head>
<body class="body-principal">
    <div id="navbar"></div>
    <div id="main">
        <div class="container mt-4">
            <div id="cards" class="row"></div>
        </div>
        <div><a href="fichaDeTreino.php"><button class="btn-negative">Voltar</button></a></div>
    </div>
    <div class="modal" id="myModal" data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 id="nomeTreinoModal"></h1>
                </div>
                <div class="modal-body">
                    <div id = "modal-data"></div>
                    <div class="container">
                        <h1 class="text-center">Exercícios</h1>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Exercício</th>
                                    <th>Quantidade de Séries</th>
                                    <th>Faixa de Repetições</th>
                                    <th>Tempo de Descanso</th>
                                </tr>
                            </thead>
                            <tbody id="tabelaExercicios"></tbody>
                        </table>
                    </div>
                <div class="modal-footer">
                    <button class="btn-negative" type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="modalExercicio" data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button class="btn-negative" type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
<script src="../../utilitarios/jquery-3.7.1.min.js"></script>
<script>
        var idFichaDeTreino;
        var idInstrutor;
        $(document).ready(function() {
            var idInstrutor = <?php echo json_encode($_SESSION["idInstrutor"]); ?>;
            var idFichaDeTreino = <?php echo json_encode($_GET['idFichaDeTreino']); ?>;
            pegarPorId(idInstrutor);
            pegarPorIdDaFicha(idFichaDeTreino)
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

            function pegarPorIdDaFicha(idFichaDeTreino){
                $.ajax({
                url: "../../controle/treinoControle.php",
                type: "POST",
                data: {
                    acao: "pegarPorIdDaFicha",
                    idFichaDeTreino: idFichaDeTreino
                },
                success: function(retorno) {
                    var result = JSON.parse(retorno);
                    
                    if (Array.isArray(result) && result.length > 0) {
                        result.forEach(function(item) {
                            var cardHtml = `
                                <div onclick="openModal(${item.idTreino})" class="card" data-bs-toggle="modal" data-bs-target="#myModal">
                                    <div class="card-body">
                                        <h5 class="card-title">${item.nome}</h5>
                                        <p class="card-text"><strong>Descrição:</strong> ${item.descricao}</p>
                                        <p class="card-text"><strong>Dia do Treino:</strong> ${item.diaDoTreino}</p>
                                        <p class="card-text"><strong>Tempo de Duração:</strong> ${item.tempoDeDuracao} minutos</p>
                                    </div>
                                </div>
                            `;
                            $('#cards').append(cardHtml);
                        })
                    } else {
                        console.error('Nenhum dado foi retornado.');
                    }
                },
                error: function(error) {
                    console.error('Erro ao carregar dados do praticante:', error);
                }
            });
            }

            var treinoIdGlobal;
            function openModal(idTreino) {
                treinoIdGlobal = idTreino;
                // Limpar o conteúdo do modal antes de carregar os novos dados
                $('#modal-data').empty();
                
                // Realizar a requisição para pegar os dados do treino
                $.ajax({
                    url: "../../controle/treinoControle.php",
                    type: "POST",
                    data: {
                        acao: "pegarPorId",
                        idTreino: idTreino
                    },
                    success: function(retorno) {
                        var result = JSON.parse(retorno); 
                        
                        if (Array.isArray(result) && result.length > 0) {
                            var treino = result[0]; 

                            $('#nomeTreinoModal').text(treino.nome);
                            $('#modal-data').append(`
                            <p><strong>Descrição:</strong> ${treino.descricao}</p>
                            <p><strong>Dia do Treino:</strong> ${treino.diaDoTreino}</p>
                            <p><strong>Tempo de Duração:</strong> ${treino.tempoDeDuracao} minutos</p>
                        `);
                        } else {
                            console.error('Nenhum dado foi retornado.');
                        }                    
                    },
                    error: function(error) {
                        console.error('Erro ao carregar dados da ficha de treino:', error);
                    }
                });
                $.ajax({
                    url: "../../controle/exercicioDoTreinoControle.php",
                    type: "POST",
                    data: {
                        acao: "pegarPorId",
                        idTreino: idTreino
                    },
                    success: function(retorno) {
                        var result = JSON.parse(retorno);
                        
                        if (Array.isArray(result) && result.length > 0) {
                            $('#tabelaExercicios').empty(); 
                            result.forEach(function(item) {
                            var rowHtml = `
                                <tr onclick="openModalExercicio(${item.idExercicio})">
                                    <td>${item.nome}</td>
                                    <td>${item.series}</td>
                                    <td>${item.repeticoes}</td>
                                    <td>${item.descanso} segundos</td>
                                </tr>
                            `;
                            $('#tabelaExercicios').append(rowHtml);
                        });
                        } else {
                            console.error('Nenhum dado foi retornado.');
                        }       
                    },
                    error: function(error) {
                        console.error('Erro ao carregar dados da ficha de treino:', error);
                    }
                });
            }

            function openModalExercicio(idExercicio) {
                $.ajax({
                    url: "../../controle/exercicioControle.php",
                    type: "POST",
                    data: {
                        acao: "pegarPorId",
                        idExercicio: idExercicio
                    },
                    success: function(retorno) {
                        var result = JSON.parse(retorno);
                        
                        if (Array.isArray(result) && result.length > 0) {
                            var exercicio = result[0];

                            $('#modalExercicio .modal-header').html(`
                                <h2>${exercicio.nome}</h2>
                            `);
                            $('#modalExercicio .modal-body').html(`
                                <p><strong>Descrição:</strong> ${exercicio.descricao}</p>
                                <p><strong>Instrução:</strong> ${exercicio.instrucao}</p>
                            `);

                            var myModalExercicio = new bootstrap.Modal(document.getElementById('modalExercicio'));
                            myModalExercicio.show(); 
                        } else {
                            console.error('Nenhum dado foi retornado.');
                        }
                    },
                    error: function(error) {
                        console.error('Erro ao carregar dados do exercício:', error);
                    }
                });
            }


</script>
    <!-- Bootstrap e Popper JS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>