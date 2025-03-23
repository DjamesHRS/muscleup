<?php
    session_start();
    if (!isset($_SESSION["idPraticante"])) {
        header("location:index.html");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../../utilitarios/loadNavbar.js"></script>
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
    var idPraticante;
    $(document).ready(function() {
        var idPraticante = <?php echo json_encode($_SESSION["idPraticante"]); ?>;
        pegarPorId(idPraticante);
    });

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
 
    function pegarPorId(idPraticante) {
        $.ajax({
                url: "../../controle/fichaDeTreinoControle.php",
                type: "POST",
                data: {
                    acao: "pegarPorId",
                    idPraticante: idPraticante
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
                                    <div class="card-body" onclick="pegarPorIdDaFicha(${item.idFichaDeTreino})">
                                        <p class="card-text"><strong>Objetivo:</strong> ${objetivoFormatado}</p>
                                        <p class="card-text"><strong>Nível:</strong> ${nivelFormatado}</p>
                                        <p class="card-text"><strong>Dias:</strong> ${diasFormatados}</p>
                                        <p class="card-text"><strong>Foco Muscular:</strong> ${focoFormatado}</p>
                                        <p class="card-text"><strong>Observações:</strong> ${observacaoFormatada}</p>
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
                            } else if (item.status === "desenvolvido") {
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

        var idFichaAtual; 

        function abrirModalAlterar(idFichaDeTreino) {
            idFichaAtual = idFichaDeTreino; 
            $('#modalAlterar').modal('show'); 
        }

        function abrirModalExcluir(idFichaDeTreino) {
            idFichaAtual = idFichaDeTreino;
            $('#modalExcluir').modal('show'); 
        }

    
        function alterarFicha() {
            var novoNome = $("#nomeAlterar").val();
            if (!novoNome) {
                alert("Por favor, informe um nome para a ficha.");
                return;
            }

            $.ajax({
                url: "../../controle/fichaDeTreinoControle.php",
                type: "POST",
                data: {
                    acao: "alterarNome",
                    idFichaDeTreino: idFichaAtual,
                    nome: novoNome,
                },
                success: function(retorno) {
                    alert("Nome da Ficha de Treino alterado com sucesso!");
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


        function pegarPorIdDaFicha(idFichaDeTreino) {
            $.ajax({
                    url: "../../controle/fichaDeTreinoControle.php",
                    type: "POST",
                    data: {
                        acao: "pegarPorId",
                        idFichaDeTreino: idFichaDeTreino
                    },
                    success: function(retorno) {
                        result = JSON.parse(retorno);
                        console.log(result);
                        if (Array.isArray(result) && result.length > 0) {
                            var ficha = result[0];
                            if (ficha.status === "desenvolvido") {
                                window.location.href = "treinos.php?idFichaDeTreino=" + ficha.idFichaDeTreino;
                            } else {
                                alert("A ficha ainda não foi desenvolvida.");
                            }
                        } else {
                            console.error('Nenhum dado foi retornado.');
                        }
                    },
                    error: function(error) {
                        console.error('Erro ao carregar dados do praticante:', error);
                    }
                });
        }
</script>
    <!-- Bootstrap e Popper JS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>