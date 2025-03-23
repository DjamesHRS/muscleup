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
        <div><button class="btn-positive" onclick="finalizarFichaDeTreino()">Finalizar Ficha De Treino</button></div>
    </div>
    <div class="modal" id="myModal" data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <label for="nomeTreinoModal">Nome do Treino:</label>
                    <input name="nomeTreinoModal" class="form-control" type="text" id="nomeTreinoModal">
                </div>
                <div class="modal-body">
                    <div id="modal-data"></div><br>
                    <div class="form-group">
                        <label for="descricaoModal">Descrição:</label>
                        <textarea class="form-control" id="descricaoModal" cols="10" rows="3"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="diaDoTreino">Dia do Treino:</label>
                        <select name="diaDoTreino" id="diaDoTreinoModal">
                            <option value="0">Selecione</option>
                            <option value="segundaFeira">Segunda-Feira</option>
                            <option value="tercaFeira">Terça-Feira</option>
                            <option value="quartaFeira">Quarta-Feira</option>
                            <option value="quintaFeira">Quinta-Feira</option>
                            <option value="sextaFeira">Sexta-Feira</option>
                            <option value="sabado">Sábado</option>
                            <option value="domingo">Domingo</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="tempoDeDuracaoModal">Tempo de Duração (minutos):</label>
                        <input class="form-control" type="number" id="tempoDeDuracaoModal">
                    </div>

                    <button class="btn-neutral" id="adicionarTreinoBtn" onclick="adicionarExercicio()">Adicionar Exercicio</button>
                    <div id="exercicio"></div>
                </div>

                <div class="modal-footer">
                    <button class="btn-positive" onclick="finalizarTreino()">Finalizar Treino</button>
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

                            $('#nomeTreinoModal').val(treino.nome);
                            $('#descricaoModal').val(treino.descricao);
                            $('#diaDoTreinoModal').val(treino.diaDoTreino); 
                            $('#tempoDeDuracaoModal').val(treino.tempoDeDuracao);
                        } else {
                            console.error('Nenhum dado foi retornado.');
                        }                    
                    },
                    error: function(error) {
                        console.error('Erro ao carregar dados da ficha de treino:', error);
                    }
                });
            }

// Array global para armazenar os dados dos exercícios
var exerciciosData = [];

function adicionarExercicio() {
    $.ajax({
        url: "../../controle/exercicioControle.php",
        type: "POST",
        data: {
            acao: "pegarTodos",
        },
        success: function(retorno) {
            var result = JSON.parse(retorno);

            if (Array.isArray(result) && result.length > 0) {
                // Criação de um novo bloco de exercício
                var blocoExercicio = $('<div class="bloco-exercicio"></div>');

                // Criar o select de exercícios
                var selectHtml = '<label for="exercicioSelect">Escolha o exercício:</label>';
                selectHtml += '<select class="form-control exercicioSelect">'; 
                selectHtml += '<option value="">Selecione um exercício</option>';

                // Iterar pelos exercícios e criar as opções
                result.forEach(function(item) {
                    selectHtml += `<option value="${item.idExercicio}">${item.nomeExercicio}</option>`;
                });

                selectHtml += '</select>';
                blocoExercicio.append(selectHtml);

                // Criar os campos de entrada para quantidade de séries, faixa de repetições e tempo de descanso
                var inputHtml = `
                    <div class="inputs-exercicio" style="display: none;">
                        <div class="form-group">
                            <label for="quantidadeSeries">Quantidade de Séries:</label>
                            <input class="form-control quantidadeSeries" type="number" placeholder="Digite a quantidade de séries">
                        </div>
                        <div class="form-group">
                            <label for="intervaloRepeticoes">Faixa de Repetições:</label>
                            <input class="form-control intervaloRepeticoes" type="text" placeholder="Ex: 8-10">
                        </div>
                        <div class="form-group">
                            <label for="tempoDescanso">Tempo de Descanso (segundos):</label>
                            <input class="form-control tempoDescanso" type="number" placeholder="Tempo de descanso entre séries">
                        </div>
                    </div>
                `;
                blocoExercicio.append(inputHtml);

                // Adicionar o novo bloco de exercício ao container de treino
                $('#exercicio').append(blocoExercicio);

                // Ao selecionar um exercício, mostrar os campos de entrada
                blocoExercicio.find('.exercicioSelect').on('change', function() {
                    var selectedExercicio = $(this).val();
                    var inputsDiv = $(this).closest('.bloco-exercicio').find('.inputs-exercicio');
                    
                    if (selectedExercicio) {
                        // Mostrar os campos de entrada
                        inputsDiv.show();
                    } else {
                        // Esconder os campos se nada for selecionado
                        inputsDiv.hide();
                    }
                });
            } else {
                console.error('Nenhum dado foi retornado.');
            }
        },
        error: function(error) {
            console.error('Erro ao carregar dados dos exercícios:', error);
        }
    });
}

// Função para coletar os dados e armazená-los no array
function coletarDadosExercicios() {
    exerciciosData = []; // Limpa o array antes de adicionar novos dados

    // Iterar sobre cada bloco de exercício
    $('.bloco-exercicio').each(function() {
        var exercicioSelect = $(this).find('.exercicioSelect').val();
        var quantidadeSeries = $(this).find('.quantidadeSeries').val();
        var intervaloRepeticoes = $(this).find('.intervaloRepeticoes').val();
        var tempoDescanso = $(this).find('.tempoDescanso').val();

        // Verificar se todos os dados estão presentes
        if (exercicioSelect && quantidadeSeries && intervaloRepeticoes && tempoDescanso) {
            var exercicioData = {
                idExercicio: exercicioSelect,
                quantidadeSeries: quantidadeSeries,
                intervaloRepeticoes: intervaloRepeticoes,
                tempoDescanso: tempoDescanso,
                idTreino: treinoIdGlobal
            };
            //console.log(exercicioData);
            exerciciosData.push(exercicioData);
        }
    });

    //console.log('Dados dos exercícios:', exerciciosData);
}


function finalizarTreino() {
    // Coletar os dados dos exercícios
    coletarDadosExercicios();
    //console.log(exerciciosData);

    // Verificar se há exercícios para salvar
    if (exerciciosData.length > 0) {
        // Enviar os dados via AJAX
        $.ajax({
            url: "../../controle/ExercicioDotreinoControle.php",
            type: "POST",
            data: {
                acao: "adicionarExercicios",
                exercicios: JSON.stringify(exerciciosData),
                idFichaDeTreino: <?php echo json_encode($_GET['idFichaDeTreino']); ?>, 
                idTreino: treinoIdGlobal
            },
            success: function(response) {
                console.log('Dados salvos com sucesso:', response);
                //alert("Exercícios adicionados com sucesso!");

                $('#myModal').modal('hide');
            },
            error: function(error) {
                console.error('Erro ao salvar os dados:', error);
                alert("Erro ao salvar os dados!");
            }
        });
    } else {
        alert('Não há exercícios para salvar.');
    }

    $.ajax({
            url: "../../controle/TreinoControle.php",
            type: "POST",
            data: {
                acao: "alterar",
                idTreino: treinoIdGlobal,
                nome: $("#nomeTreinoModal").val(),
                descricao: $("#descricaoModal").val(),
                diaDoTreino: $("#diaDoTreinoModal").val(),
                tempoDeDuracao: $("#tempoDeDuracaoModal").val(),
            },
            success: function(retorno) {
                var idFichaDeTreino = <?php echo json_encode($_GET['idFichaDeTreino']); ?>;
                window.location.href = "treinos.php?idFichaDeTreino=" + idFichaDeTreino;
            },
            error: function(error) {
                console.error('Erro ao finalizar ficha de treino:', error);
            }
        });

}
    function finalizarFichaDeTreino() {
        $.ajax({
            url: "../../controle/fichaDeTreinoControle.php",
            type: "POST",
            data: {
                acao: "alterarStatus",
                idFichaDeTreino: <?php echo json_encode($_GET['idFichaDeTreino']); ?>, 
                status: "desenvolvido"
            },
            success: function(retorno) {
                window.location.href = "fichaDeTreino.php";
            },
            error: function(error) {
                console.error('Erro ao finalizar ficha de treino:', error);
            }
        });
    
}

</script>
    <!-- Bootstrap e Popper JS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>