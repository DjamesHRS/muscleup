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
        <link rel="stylesheet" href="../../utilitarios/style.css">
        <title>Fichas de Treino</title>
    </head>
<body class="body-principal">
    <div id="navbar"></div>
    <div id="main">
        <div id=paginacao>
            <a onclick="showDesenvolvidos()">Desenvolvidas</a> 
            <p> | </p> 
            <a onclick="showNaoDesenvolvidos()">A Desenvolver</a>
        </div>
        <div id="desenvolvidos"  class="container mt-4">
            <h1>Fichas de Treino Desenvolvidas</h1><br>
            <div class="row" id="fichasDesenvolvidas" ></div>
        </div>

        <div id="nao-desenvolvidos" class="container mt-4" style="display: none">
            <h1>Fichas de Treino a Desenvolver</h1><br>
            <div class="row" id="fichasNaoDesenvolvidas" ></div>
        </div>
    </div>
    <div class="modal" id="myModal" data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Ficha de Treino</h2>
                </div>
                <div class="modal-body">
                    <div id="modal-data"></div><br>
                    <h2>Finalizar Ficha de Treino</h2>
                    <div class="form-group">
                        <label for="nome">Nome da Ficha de Treino:</label>
                        <input class="form-control" placeholder="Informe o nome da ficha de treino" type="text" name="nome" id="nome">
                    </div>
                    <div class="form-group">
                        <label for="dataCriacao">Data de Criação:</label>
                        <input class="form-control" placeholder="Informe a data de criação" type="date" name="dataCriacao" id="dataCriacao">
                    </div>

                    <div class="form-group">
                        <label for="descricao">Descrição:</label>
                        <textarea name="descricao" id="descricao" class="form-control" placeholder="Informe uma breve descricão sobre a ficha de treino" cols="10" rows="3"></textarea>
                    </div>
                    <button class="btn-neutral" id="adicionarTreinoBtn" onclick="adicionarTreino()">Adicionar Treino</button>
                    <div id="treino"></div>
                </div>
                <div class="modal-footer">
                    <button class="btn-positive" onclick="finalizar()">Finalizar Ficha de Treino</button>
                    <button class="btn-negative" type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="modalAlterar" data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Alterar Dados da Ficha de Treino</h2>
                </div>
                <div class="modal-body">
                <div class="form-group">
                    <label for="nomeAlterar">Nome da Ficha de Treino:</label>
                    <input name="nomeAlterar" id="nomeAlterar" class="form-control" placeholder="Informe o novo nome da ficha de treino" type="text">
                </div>
                <div class="form-group">
                    <label for="descricaoAlterar">Descrição da Ficha de Treino:</label>
                    <textarea class="form-control" name="descricaoAlterar" id="descricaoAlterar"></textarea>
                </div>
                </div>
                <div class="modal-footer">
                    <button class="btn-positive" onclick="alterarFicha()">Alterar</button>
                    <button class="btn-negative" type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="modalExcluir" data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Excluir Ficha de Treino</h2>
                </div>
                <div class="modal-body">
                    <h3>Você tem certeza que deseja excluir a ficha de treino?</h3>
                </div>
                <div class="modal-footer">
                    <button class="btn-negative" onclick="excluirFicha()">Sim</button>
                    <button class="btn-positive" type="button" class="btn btn-danger" data-bs-dismiss="modal">Não</button>

                </div>
            </div>
        </div>
    </div>

<script src="../../utilitarios/jquery-3.7.1.min.js"></script>
<script>
        var fichaAtualId;
        var idInstrutor;
        $(document).ready(function() {
            var idInstrutor = <?php echo json_encode($_SESSION["idInstrutor"]); ?>;
            pegarPorId(idInstrutor);

            var today = new Date();
            var day = ("0" + today.getDate()).slice(-2);  // Adiciona zero à esquerda, se necessário
            var month = ("0" + (today.getMonth() + 1)).slice(-2);  // Meses começam do 0, então somamos 1
            var year = today.getFullYear();

            var currentDate = year + "-" + month + "-" + day;  // Formato: YYYY-MM-DD

            // Define o valor do campo "dataCriacao"
            $('#dataCriacao').val(currentDate);

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

                $.ajax({
                url: "../../controle/fichaDeTreinoControle.php",
                type: "POST",
                data: {
                    acao: "pegarPorId",
                    idInstrutor: idInstrutor
                },
                success: function(retorno) {
                    var result = JSON.parse(retorno);
                    
                    if (Array.isArray(result) && result.length > 0) {
                        result.forEach(function(item) {
                            // Função para formatar texto (separar palavras, corrigir ortografia e capitalizar)
                            function formatarTexto(texto) {
                                if (!texto) return texto; // Retorna o texto original se vazio ou indefinido
                                // Substitui palavras compostas e deixa a primeira letra de cada palavra maiúscula
                                texto = texto.replace(/([A-Z])/g, ' $1').replace(/^./, function(str) { return str.toUpperCase(); }); // Adiciona espaço entre palavras compostas
                                // Corrige dias da semana
                                var dias = {
                                    "segundaFeira": "Segunda-feira",
                                    "tercaFeira": "Terça-feira",
                                    "quartaFeira": "Quarta-feira",
                                    "quintaFeira": "Quinta-feira",
                                    "sextaFeira": "Sexta-feira",
                                    "sabado": "Sábado",
                                    "domingo": "Domingo"
                                };
                                Object.keys(dias).forEach(function(dia) {
                                    texto = texto.replace(new RegExp(dia, 'g'), dias[dia]);
                                });
                                return texto;
                            }

                            // Formatar os dados antes de exibir
                            var objetivoFormatado = formatarTexto(item.objetivo);
                            var nivelFormatado = formatarTexto(item.nivelDeTreino);
                            var diasFormatados = formatarTexto(item.diasDeTreino); // Caso venha como JSON, precisamos tratar isso também
                            var focoFormatado = formatarTexto(item.focoMuscular);
                            var observacaoFormatada = formatarTexto(item.observacoes);
                            var statusFormatado = formatarTexto(item.status);

                            // Exemplo de como colocar os valores formatados nos campos
                            $('#objetivo').val(objetivoFormatado);
                            $('#nivel').val(nivelFormatado);
                            $('#dias').val(diasFormatados);
                            $('#foco').val(focoFormatado);
                            $('#observacao').val(observacaoFormatada);
                            $('#status').val(statusFormatado);

                            // Cria um card para cada ficha de treino
                            var cardHtml = `
                                <div class="card">
                                    <div class="card-title"><h2>${item.nome}</h2></div>
                                    <div class="card-body"onclick="openModal(${item.idFichaDeTreino})" class="card" data-bs-toggle="modal" data-bs-target="#myModal" data-id="${item.idFichaDeTreino}">
                                        <p class="card-text"><strong>Objetivo:</strong> ${objetivoFormatado}</p>
                                        <p class="card-text"><strong>Nível:</strong> ${nivelFormatado}</p>
                                        <p class="card-text"><strong>Dias:</strong> ${diasFormatados}</p>
                                        <p class="card-text"><strong>Foco Muscular:</strong> ${focoFormatado}</p>
                                        <p class="card-text"><strong>Observações:</strong> ${observacaoFormatada}</p>
                                        <p class="card-text"><strong>Descrição:</strong> ${item.descricao}</p>
                                        <p class="card-text"><strong>Instrutor:</strong> ${item.nome_instrutor}</p>
                                        <p class="card-text"><strong>Status:</strong> ${statusFormatado}</p>
                                    </div>
                                    <div class="card-footer">
                                        <button onclick="abrirModalAlterar(${item.idFichaDeTreino})" class="btn-neutral">Alterar</button>
                                        <button onclick="abrirModalExcluir(${item.idFichaDeTreino})" class="btn-negative">Excluir</button>
                                    </div>
                                </div>
                            `;

                            // Verifica o status e adiciona o card no elemento correto
                            if (item.status === "naoDesenvolvido") {
                                $('#fichasNaoDesenvolvidas').append(cardHtml);
                            }else if (item.status === "desenvolvido"){
                                $('#fichasDesenvolvidas').append(cardHtml);
                            }
                        });
                    } else {
                        console.error('Nenhum dado foi retornado.');
                    }
                },
                error: function(error) {
                    console.error('Erro ao carregar dados do praticante:', error);
                }
            });
            }

        function showDesenvolvidos() {
            document.getElementById('desenvolvidos').style.display = 'block';
            document.getElementById('nao-desenvolvidos').style.display = 'none';

            // Alterar a classe active para o link de "Desenvolvidos"
            document.getElementById('linkDesenvolvidos').classList.add('active');
            document.getElementById('linkNaoDesenvolvidos').classList.remove('active');
        }

        function showNaoDesenvolvidos() {
            document.getElementById('nao-desenvolvidos').style.display = 'block';
            document.getElementById('desenvolvidos').style.display = 'none';

            // Alterar a classe active para o link de "Não Desenvolvidos"
            document.getElementById('linkNaoDesenvolvidos').classList.add('active');
            document.getElementById('linkDesenvolvidos').classList.remove('active');
        }
        
        function openModal(fichaId) {
            fichaAtualId = fichaId;
            $('#modal-data').empty();  

            $.ajax({
                url: "../../controle/fichaDeTreinoControle.php",
                type: "POST",
                data: {
                    acao: "pegarPorId",
                    idFichaDeTreino: fichaAtualId
                },
                success: function(retorno) {
                    var result = JSON.parse(retorno); 
                    if (Array.isArray(result) && result.length > 0) {
                        var ficha = result[0];
                            if (ficha.status === "desenvolvido") {
                                window.location.href = "treinosDesenvolvidos.php?idFichaDeTreino=" + ficha.idFichaDeTreino;
                            } else {
                                result.forEach(function(item) {
                                var modal = `
                                            <p class="card-text"><strong>Objetivo:</strong> ${item.objetivo}</p>
                                            <p class="card-text"><strong>Nível:</strong> ${item.nivelDeTreino}</p>
                                            <p class="card-text"><strong>Dias:</strong> ${item.diasDeTreino}</p>
                                            <p class="card-text"><strong>Foco Muscular:</strong> ${item.focoMuscular}</p>
                                            <p class="card-text"><strong>Observações:</strong> ${item.observacoes}</p>
                                            <p class="card-text"><strong>Instrutor:</strong> ${item.nome_instrutor}</p>
                                            <p class="card-text"><strong>Status:</strong> ${item.status}</p>
                                `;
                                $('#modal-data').append(modal);
                            });
                            }
                        } else {
                            console.error('Nenhum dado foi retornado.');
                        }                    
                },
                error: function(error) {
                    console.error('Erro ao carregar dados da ficha de treino:', error);
                }
            });

        }

    var treinoCount = 0; 

    function adicionarTreino() {
        treinoCount++;

        var treinoHtml = `
            <div class="treino-container" id="treino_${treinoCount}">
                <h5>Treino ${treinoCount}</h5>
                
                <div class="form-group">
                    <label for="nomeTreino_${treinoCount}">Nome do Treino:</label>
                    <input class="form-control" placeholder="Informe o nome do treino" type="text" name="nomeTreino_${treinoCount}" id="nomeTreino_${treinoCount}">
                </div>

                <div class="form-group">
                    <label for="descricaoTreino_${treinoCount}">Descrição:</label>
                    <textarea name="descricaoTreino_${treinoCount}" id="descricaoTreino_${treinoCount}" class="form-control" placeholder="Informe uma breve descrição sobre o treino" cols="10" rows="3"></textarea>
                </div>

                <div class="form-group">
                    <label for="diaTreino_${treinoCount}">Dia de Treino:</label>
                    <select name="dia" id="dia_${treinoCount}">
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
                    <label for="duracaoTreino_${treinoCount}">Tempo de Duração (em minutos):</label>
                    <input type="number" name="duracaoTreino_${treinoCount}" id="duracaoTreino_${treinoCount}" class="form-control" placeholder="Informe o tempo de duração">
                </div>
            </div>
        `;

        $('#treino').append(treinoHtml);

        var adicionarTreinoBtn = $('#adicionarTreinoBtn');
        $('#treino').append(adicionarTreinoBtn);
    }

    function finalizar(fichaId) {
        fichaAtualId = fichaId || fichaAtualId;

        // Verifique se fichaAtualId está realmente atribuído antes de enviar a requisição
        if (!fichaAtualId) {
            console.error("Erro: fichaAtualId não foi atribuído corretamente.");
            return;
        }

        // Envio dos dados básicos da ficha de treino
        $.ajax({
            url: "../../controle/fichaDeTreinoControle.php",
            type: "POST",
            data: {
                acao: "alterar",
                idFichaDeTreino: fichaAtualId,  // Passando o fichaId
                nome: $("#nome").val(),
                dataCriacao: $("#dataCriacao").val(),
                descricao: $("#descricao").val(),
            },
            success: function(retorno) {
                console.log("Resposta ao tentar finalizar a ficha de treino:", retorno);
            },
            error: function(error) {
                console.error('Erro ao finalizar ficha de treino:', error);
            }
        });

        var treinos = [];  

        for (var i = 1; i <= treinoCount; i++) {
            var nome = $('#nomeTreino_' + i).val();
            var descricao = $('#descricaoTreino_' + i).val();
            var dia = $('#dia_' + i).val();
            var duracao = $('#duracaoTreino_' + i).val();

            if (!nome || !descricao || !dia || !duracao) {
                alert("Por favor, preencha todos os campos do treino " + i + ".");
                return;
            }

            var treino = {
                nome: nome,
                descricao: descricao,
                dia: dia,
                duracao: duracao,
                idFichaDeTreino: fichaAtualId
            };

            treinos.push(treino);
        }

        $.ajax({
            url: "../../controle/treinoControle.php",
            type: "POST",
            data: {
                acao: "cadastrar",
                idFichaDeTreino: fichaAtualId,
                treinos: JSON.stringify(treinos) 
            },
            success: function(response) {
                window.location.href = "treinos.php?idFichaDeTreino=" + fichaAtualId;
            },
            error: function(error) {
                console.error('Erro ao enviar dados:', error);
            }
        });
    }

    var idFichaAtual; 

        function abrirModalAlterar(idFichaDeTreino) {
            idFichaAtual = idFichaDeTreino;

            $.ajax({
                url: "../../controle/fichaDeTreinoControle.php",
                type: "POST",
                data: {
                    acao: "pegarPorId",
                    idFichaDeTreino: idFichaAtual
                },
                success: function(retorno) {
                    var result = JSON.parse(retorno); 
                    if (Array.isArray(result) && result.length > 0) {
                        var ficha = result[0];
                                result.forEach(function(item) {
                                    document.getElementById("nomeAlterar").value = ficha.nome;
                                    document.getElementById("descricaoAlterar").value = ficha.descricao;
                            });
                        } else {
                            console.error('Nenhum dado foi retornado.');
                        }                    
                },
                error: function(error) {
                    console.error('Erro ao carregar dados da ficha de treino:', error);
                }
            });
             
            $('#modalAlterar').modal('show'); 
        }

        function abrirModalExcluir(idFichaDeTreino) {
            idFichaAtual = idFichaDeTreino;
            $('#modalExcluir').modal('show'); 
        }

    
        function alterarFicha() {
            $.ajax({
                url: "../../controle/fichaDeTreinoControle.php",
                type: "POST",
                data: {
                    acao: "alterarInstrutor",
                    idFichaDeTreino: idFichaAtual,
                    nome: $("#nomeAlterar").val(),
                    descricao: $("#descricaoAlterar").val(),
                },
                success: function(retorno) {
                    alert("Ficha de Treino alterado com sucesso!");
                    location.reload();
                },
                error: function(error) {
                    console.error('Erro ao alterar a ficha de treino:', error);
                    alert("Erro ao alterar a ficha de treino. Tente novamente.");
                }
            });
        }

        function excluirFicha() {
            $.ajax({
                url: "../../controle/fichaDeTreinoControle.php",
                type: "POST",
                data: {
                    acao: "alterarStatus",
                    idFichaDeTreino: idFichaAtual, 
                    status: "desativado"
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