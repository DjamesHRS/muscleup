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
    <title>Praticantes</title>
</head>
<body class="body-principal">
<div id="navbar"></div>
    <!-- Conteúdo Principal -->
    <div id="main">
    <button class="btn-positive" onclick="openModalCadastrar()">Cadastrar Praticante</button>
        <div class="container mt-4">
            <h1 class="text-center">Praticantes</h1>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Data de Nascimento</th>
                        <th>Sexo</th>
                        <th>Altura</th>
                        <th>Peso</th>
                    </tr>
                </thead>
                <tbody id="tabelaPraticantes" data-bs-toggle="modal" data-bs-target="#myModal"></tbody>
            </table>
        </div>

        <div class="modal" id="myModal" data-bs-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 id="nomePraticante"></h1>
                    </div>
                    <div class="modal-body" id="modalBody">
                        <div id="praticante"></div>
                        <div id="fichasDeTreino"></div>
                    </div>
                    <div id="modalFooter" class="modal-footer">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="modalCadastrar" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Cadastrar Praticante</h2>
            </div>
            <div class="modal-body">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input name="nome" id="nome" class="form-control" placeholder="Informe seu nome" type="text">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input name="email" id="email" class="form-control" placeholder="Informe seu email" type="email">
            </div>
            <div class="form-group">
                <label for="senha">Senha:</label>
                <input name="senha" id="senha" class="form-control" placeholder="Informe sua senha" type="password">
            </div>
            <div class="form-group">
                <label for="dataDeNascimento">Data de Nascimento:</label>
                <input name="dataDeNascimento" id="dataDeNascimento" class="form-control" placeholder="Informe sua data de nascimento" type="date">
            </div>
            <div class="form-group">
                <label for="peso">Peso:</label>
                <input name="peso" id="peso" class="form-control" placeholder="Informe seu peso" type="text">
            </div>
            <div class="form-group">
                <label for="altura">Altura:</label>
                <input name="altura" id="altura" class="form-control" placeholder="Informe sua altura" type="text">
            </div>
            <div class="form-group">
                <label for="sexo">Sexo:</label>
                <select name="sexo" id="sexo" class="form-control" name="sexo" id="sexo">
                    <option value="">Selecione</option>
                    <option value="feminino">Feminino</option>
                    <option value="masculino">Masculino</option>
                    <option value="outro">Outro</option>
                </select>
            </div>
            </div>
            <div class="modal-footer">
                <button class="btn-positive" id="button" onclick="cadastrar()">Cadastrar</button>
                <button class="btn-neutral" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="modalAlterarPraticante" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Alterar Praticante</h2>
            </div>
            <div class="modal-body">
            <div class="form-group">
                <label for="nomeModal">Nome:</label>
                <input name="nomeModal" id="nomeModal" class="form-control" placeholder="Informe seu nome" type="text">
            </div>
            <div class="form-group">
                <label for="emailModal">Email:</label>
                <input name="emailModal" id="emailModal" class="form-control" placeholder="Informe seu email" type="email">
            </div>
            <div class="form-group">
                <label for="senhaModal">Senha:</label>
                <input name="senhaModal" id="senhaModal" class="form-control" placeholder="Informe sua senha" type="password">
            </div>
            <div class="form-group">
                <label for="dataDeNascimento">Data de Nascimento:</label>
                <input name="dataDeNascimentoModal" id="dataDeNascimentoModal" class="form-control" placeholder="Informe sua data de nascimento" type="date">
            </div>
            <div class="form-group">
                <label for="pesoModal">Peso:</label>
                <input name="pesoModal" id="pesoModal" class="form-control" placeholder="Informe seu peso" type="text">
            </div>
            <div class="form-group">
                <label for="alturaModal">Altura:</label>
                <input name="alturaModal" id="alturaModal" class="form-control" placeholder="Informe sua altura" type="text">
            </div>
            <div class="form-group">
                <label for="sexoModal">Sexo:</label>
                <select name="sexoModal" id="sexoModal" class="form-control" name="sexo" id="sexo">
                    <option value="">Selecione</option>
                    <option value="feminino">Feminino</option>
                    <option value="masculino">Masculino</option>
                    <option value="outro">Outro</option>
                </select>
            </div>
            </div>
            <div class="modal-footer">
                <button class="btn-positive" id="button" onclick="alterar()">Alterar</button>
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="modalExcluirPraticante" data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Excluir Praticante</h2>
                </div>
                <div class="modal-body">
                    <h3>Você tem certeza que deseja excluir o praticante?</h3>
                </div>
                <div class="modal-footer">
                    <button class="btn-negative" onclick="excluirPraticante()">Sim</button>
                    <button class="btn-positive" type="button" class="btn btn-danger" data-bs-dismiss="modal">Não</button>

                </div>
            </div>
        </div>
    </div>

<div class="modal" id="modalAlterarFichaDeTreino" data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Alterar Dados da Ficha de Treino</h2>
                </div>
                <div class="modal-body">
                <div class="form-group">
                    <label for="nomeFichaAlterar">Nome da Ficha de Treino:</label>
                    <input name="nomeFichaAlterar" id="nomeFichaAlterar" class="form-control" placeholder="Informe o novo nome da ficha de treino" type="text">
                </div>
                <div class="form-group">
                    <label for="instrutorAlterar">Instrutor:</label>
                    <select class="form-control" name="instrutorAlterar" id="instrutorAlterar">
                        <option value="0">Selecione</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="statusAlterar">Status:</label>
                    <select class="form-control" name="statusAlterar" id="statusAlterar">
                        <option value="0">Selecione</option>
                        <option value="naoDesenvolvido">Não desenvolvida</option>
                        <option value="desenvolvido">Desenvolvido</option>
                        <option value="desativado">Desativado</option>
                    </select>
                </div>
                </div>
                <div class="modal-footer">
                    <button class="btn-positive" onclick="alterarFicha()">Alterar</button>
                    <button class="btn-negative" type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="modalExcluirFichaDeTreino" data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Excluir Dados da Ficha de Treino</h2>
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
                    url: "../../controle/instrutorControle.php",
                    type: "POST",
                    data: {
                        acao: "pegarTodos",
                    },
                    success: function(retorno) {
                        result = JSON.parse(retorno);
                        if (Array.isArray(result)) {
                            result.forEach(function(item) {
                                $("#instrutorAlterar").append(new Option(item.nome, item.idInstrutor));
                            });
                        } else {
                            console.error("Resposta não é um array:", result);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Erro ao buscar dados: ", error);
                    }
                });

                $.ajax({
                    url: "../../controle/praticanteControle.php",
                    type: "POST",
                    data: {
                        acao: "pegarTodos",
                    },
                    success: function(retorno) {
                        var result = JSON.parse(retorno);
                        if (Array.isArray(result) && result.length > 0) {
                            var tabelaBody = document.getElementById("tabelaPraticantes");
                            var modalBody = document.getElementById("praticante");
                            var nomeInstrutor = document.getElementById("nomePraticante");
                            tabelaBody.innerHTML = "";

                            result.forEach(function(item) {
                                // Cria uma nova linha de dados na tabela
                                var tr = document.createElement("tr");

                                // Adiciona as células para cada coluna da tabela
                                var tdNome = document.createElement("td");
                                tdNome.innerText = item.nome;
                                tr.appendChild(tdNome);

                                var tdEmail = document.createElement("td");
                                tdEmail.innerText = item.email;
                                tr.appendChild(tdEmail);

                                var tdDataNascimento = document.createElement("td");
                                tdDataNascimento.innerText = item.dataDeNascimento;
                                tr.appendChild(tdDataNascimento);

                                var tdSexo = document.createElement("td");
                                tdSexo.innerText = item.sexo;
                                tr.appendChild(tdSexo);

                                var tdAltura = document.createElement("td");
                                tdAltura.innerText = item.altura;
                                tr.appendChild(tdAltura, 'm');

                                var tdPeso = document.createElement("td");
                                tdPeso.innerText = item.peso;
                                tr.appendChild(tdPeso, "Kg");


                                // Adiciona a nova linha na tabela
                                tabelaBody.appendChild(tr);

                                // Adiciona evento de clique na linha
                                tr.addEventListener("click", function() {
                                    // Exibe os dados no modal
                                    nomePraticante.innerText = item.nome;

                                    modalBody.innerHTML = `
                                        <p><strong>Email:</strong> ${item.email}</p>
                                        <p><strong>Data de Nascimento:</strong> ${item.dataDeNascimento}</p>
                                        <p><strong>Sexo:</strong> ${item.sexo}</p>
                                        <p><strong>Altura:</strong> ${item.altura}</p>
                                        <p><strong>Peso:</strong> ${item.peso}</p>
                                    `;
                                    modalFooter.innerHTML = `
                                        <button class="btn-positive" onclick="openModalAlterarPraticante(${item.idPraticante})">Alterar Praticante</button>
                                        <button class="btn-negative" onclick="openModalExcluirPraticante(${item.idPraticante})">Excluir Praticante</button>
                                        <button class="btn-neutral" type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
                                    `;
                                    pegarFichaDeTreino(item.idPraticante);
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

            function pegarFichaDeTreino(idPraticante) {
                $.ajax({
                    url: "../../controle/fichaDeTreinoControle.php",
                    type: "POST",
                    data: {
                        acao: "pegarPorId",
                        idPraticante: idPraticante
                    },
                    success: function(retorno) {
                        var result = JSON.parse(retorno);
                        var fichasDeTreino = document.getElementById("fichasDeTreino");
                        if (fichasDeTreino) {
                            fichasDeTreino.innerHTML = `<h3>Fichas de Treino:</h3>`;
                        } else {
                            console.error('Elemento fichasDeTreino não encontrado.');
                        }


                        fichasDeTreino.innerHTML = `<h3>Fichas de Treino:</h3>`; 

                        if (Array.isArray(result) && result.length > 0) {
                            result.forEach(function(item) {

                                // Função para formatar texto (separar palavras, corrigir ortografia e capitalizar)
                                function formatarTexto(texto) {
                                    if (!texto) return texto; // Retorna o texto original se vazio ou indefinido
                                    
                                    // Corrige palavras compostas e capitaliza a primeira letra de cada palavra
                                    texto = texto.replace(/([A-Z])/g, ' $1').replace(/^./, function(str) { return str.toUpperCase(); });

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
                                var diasFormatados = formatarTexto(item.diasDeTreino);
                                var focoFormatado = formatarTexto(item.focoMuscular); 
                                var observacaoFormatada = formatarTexto(item.observacoes);
                                var statusFormatado = formatarTexto(item.status);

                                // Cria um card para cada ficha de treino
                                var cardHtml = `
                                    <div class="card">
                                        <div class="card-header"><strong> ${item.nome}</strong> </div>
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
                                            <button onclick="abrirModalAlterarFichaDeTreino(${item.idFichaDeTreino})" class="btn-neutral">Alterar</button>
                                            <button onclick="abrirModalExcluirFichaDeTreino(${item.idFichaDeTreino})" class="btn-negative">Excluir</button>
                                        </div>
                                    </div>
                                `;

                                // Adiciona o card ao modal
                                $('#fichasDeTreino').append(cardHtml);
                            });
                        } else {
                            fichasDeTreino.innerHTML += `<p>Não há fichas de treino para este praticante.</p>`;
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Erro ao buscar fichas de treino: ", error);
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

        function openModalCadastrar() {
                // Mostra o modal
                $("#modalCadastrar").modal("show");
            }

            var idPraticante;
            function openModalAlterarPraticante(idPraticante){
                idAtual = idPraticante;
                $.ajax({
                    url: "../../controle/praticanteControle.php",
                    type: "POST",
                    data: {
                        acao: "pegarPorId",
                        idPraticante: idAtual
                    },
                    success: function(retorno) {
                        if (Array.isArray(retorno) && retorno.length > 0) {
                            var praticante = retorno[0];  // Pega o primeiro objeto
                            // Preenche os campos na tabela
                            document.getElementById("nomeModal").value = praticante.nome;
                            document.getElementById("emailModal").value = praticante.email;
                            document.getElementById("dataDeNascimentoModal").value= praticante.dataDeNascimento;
                            document.getElementById("sexoModal").value = praticante.sexo;
                            document.getElementById("alturaModal").value = praticante.altura;
                            document.getElementById("pesoModal").value = praticante.peso;
                            document.getElementById("nomeUsuarioModal").value = praticante.nome;
                        } else {
                            console.error('Nenhum dado foi retornado.');
                        }
                    },
                    error: function(error) {
                        console.error('Erro ao carregar dados do praticante:', error);
                    }
                });
                $("#modalAlterarPraticante").modal("show");
            }

            function alterar(idPraticante) {
                $.ajax({
                    url: "../../controle/praticanteControle.php",
                    type: "POST",
                    data: {
                        acao: "alterar",
                        idPraticante: idAtual,
                        nome: $("#nomeModal").val(),
                        email: $("#emailModal").val(),
                        senha: $("#senhaModal").val(),
                        dataDeNascimento: $("#dataDeNascimentoModal").val(),
                        altura: $("#alturaModal").val(),
                        peso: $("#pesoModal").val(),
                        sexo: $("#sexoModal").val(),
                    },
                    success: function(retorno) {
                        alert("Dados Alterados com Sucesso!");
                        location.reload();
                    }
                });
            }

            function openModalExcluirPraticante(idPraticante) {
            idAtual = idPraticante;
            $('#modalExcluirPraticante').modal('show'); 
        }

        function excluirPraticante() {
            $.ajax({
                url: "../../controle/praticanteControle.php",
                type: "POST",
                data: {
                    acao: "excluir",
                    idPraticante: idAtual, 
                },
                success: function(retorno) {
                    alert("Praticante excluído com sucesso!");
                    location.reload();
                },
                error: function(error) {
                    console.error('Erro ao excluir praticante:', error);
                }
            });
        }

            function cadastrar(){
                $.ajax({
                    url: "../../controle/praticanteControle.php",
                    type: "POST",
                    data: {
                        acao: "cadastrar",
                        nome: $("#nome").val(),
                        email: $("#email").val(),
                        senha: $("#senha").val(),
                        dataDeNascimento: $("#dataDeNascimento").val(),
                        altura: $("#altura").val(),
                        peso: $("#peso").val(),
                        sexo: $("#sexo").val(),
                    },
                    success: function(retorno){
                        window.location.href = "praticantes.php";
                    }
                });
            }

        var idFichaAtual; 

        function abrirModalAlterarFichaDeTreino(idFichaDeTreino) {
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
                                    document.getElementById("nomeFichaAlterar").value = ficha.nome;
                                    document.getElementById("instrutorAlterar").value = ficha.idInstrutor;
                                    document.getElementById("statusAlterar").value = ficha.status;
                            });
                        } else {
                            console.error('Nenhum dado foi retornado.');
                        }                    
                },
                error: function(error) {
                    console.error('Erro ao carregar dados da ficha de treino:', error);
                }
            });
             
            $('#modalAlterarFichaDeTreino').modal('show'); 
        }

        function alterarFicha() {
            $.ajax({
                url: "../../controle/fichaDeTreinoControle.php",
                type: "POST",
                data: {
                    acao: "alterarAdm",
                    idFichaDeTreino: idFichaAtual,
                    nome: $("#nomeFichaAlterar").val(),
                    instrutor: $("#instrutorAlterar").val(),
                    status: $("#statusAlterar").val(),
                },
                success: function(retorno) {
                    alert("Ficha de Treino alterada com sucesso!");
                    location.reload();
                },
                error: function(error) {
                    console.error('Erro ao alterar a ficha de treino:', error);
                    alert("Erro ao alterar a ficha de treino. Tente novamente.");
                }
            });
        }

        function abrirModalExcluirFichaDeTreino(idFichaDeTreino) {
            idFichaAtual = idFichaDeTreino;
            $('#modalExcluirFichaDeTreino').modal('show'); 
        }

        function excluirFicha() {
            $.ajax({
                url: "../../controle/fichaDeTreinoControle.php",
                type: "POST",
                data: {
                    acao: "excluir",
                    idFichaDeTreino: idFichaAtual, 
                },
                success: function(retorno) {
                    alert("Ficha de Treino excluída com sucesso!");
                    location.reload();
                },
                error: function(error) {
                    console.error('Erro ao finalizar ficha de treino:', error);
                }
            });
        }


</script>
</body>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</html>