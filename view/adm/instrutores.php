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
    <title>Instrutores</title>
</head>
<body class="body-principal">
<div id="navbar"></div>
    <!-- Conteúdo Principal -->
    <div id="main">
    <button class="btn-positive" onclick="openModalCadastrar()">Cadastrar Instrutor</button>
        <div class="container mt-4">
            <h1 class="text-center">Instrutores</h1>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Registro CREF</th>
                        <th>Data de Nascimento</th>
                        <th>Sexo</th>
                        <th>Universidade de Formação</th>
                    </tr>
                </thead>
                <tbody id="tabelaInstrutores" data-bs-toggle="modal" data-bs-target="#myModal"></tbody>
            </table>
        </div>
    </div>

    <div class="modal" id="myModal" data-bs-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 id="nomeInstrutor"></h1>
                    </div>
                    <div class="modal-body" id="modalBody">
                        <div id="instrutor"></div>
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
                    <h2>Cadastrar Instrutor</h2>
                </div>
                <div class="modal-body">
                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input name="nome" id="nome" class="form-control" placeholder="Informe seu nome" type="text" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input name="email" id="email" class="form-control" placeholder="Informe seu email" type="email" required>
                </div>
                <div class="form-group">
                    <label for="senha">Senha:</label>
                    <input name="senha" id="senha" class="form-control" placeholder="Informe sua senha" type="password" required>
                </div>
                <div class="form-group">
                    <label for="cref">Registro do CREF:</label>
                    <input name="cref" id="cref" class="form-control" placeholder="Informe seu CREF" type="text" required>
                </div>
                <div class="form-group">
                    <label for="dataDeNascimento">Data de Nascimento:</label>
                    <input name="dataDeNascimento" id="dataDeNascimento" class="form-control" placeholder="Informe sua data de nascimento" type="date" required>
                </div>
                <div class="form-group">
                    <label for="sexo">Sexo:</label>
                    <select name="sexo" id="sexo" class="form-control" name="sexo" id="sexo" required>
                        <option value="">Selecione</option>
                        <option value="feminino">Feminino</option>
                        <option value="masculino">Masculino</option>
                        <option value="outro">Outro</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="dataDeFormacao">Data de Formação:</label>
                    <input name="dataDeFormacao" id="dataDeFormacao" class="form-control" placeholder="Informe sua data de formação" type="date" required>
                </div>
                <div class="form-group">
                    <label for="universidadeDeFormacao">Universidade de Formação:</label>
                    <input name="universidadeDeFormacao" id="universidadeDeFormacao" class="form-control" placeholder="Informe sua universidade de formação" type="text" required>
                </div>
                <div class="form-group">
                    <label for="descricao">Descrição sobre o instrutor:</label>
                    <textarea name="descricao" id="descricao" class="form-control" placeholder="Informe uma breve descrição" cols="10" rows="3" required></textarea>
                </div>
                </div>
                <div class="modal-footer">
                    <button class="btn-positive" id="button" onclick="cadastrar()">Cadastrar</button>
                    <button class="btn-neutral" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="modalAlterarInstrutor" data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Alterar Instrutor</h2>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nomeModal">Nome:</label>
                        <input name="nomeModal" id="nomeModal" class="form-control" placeholder="Informe seu nome" type="text" required>
                    </div>
                    <div class="form-group">
                        <label for="emailModal">Email:</label>
                        <input name="emailModal" id="emailModal" class="form-control" placeholder="Informe seu email" type="email" required>
                    </div>
                    <div class="form-group">
                        <label for="senhaModal">Senha:</label>
                        <input name="senhaModal" id="senhaModal" class="form-control" placeholder="Informe sua senha" type="password" required>
                    </div>
                    <div class="form-group">
                        <label for="crefModal">Registro do CREF:</label>
                        <input name="crefModal" id="crefModal" class="form-control" placeholder="Informe seu CREF" type="text" required>
                    </div>
                    <div class="form-group">
                        <label for="dataDeNascimentoModal">Data de Nascimento:</label>
                        <input name="dataDeNascimentoModal" id="dataDeNascimentoModal" class="form-control" placeholder="Informe sua data de nascimento" type="date" required>
                    </div>
                    <div class="form-group">
                        <label for="sexoModal">Sexo:</label>
                        <select name="sexoModal" id="sexoModal" class="form-control" name="sexo" id="sexo" required>
                            <option value="">Selecione</option>
                            <option value="feminino">Feminino</option>
                            <option value="masculino">Masculino</option>
                            <option value="outro">Outro</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="dataDeFormacaoModal">Data de Formação:</label>
                        <input name="dataDeFormacaoModal" id="dataDeFormacaoModal" class="form-control" placeholder="Informe sua data de formação" type="date" required>
                    </div>
                    <div class="form-group">
                        <label for="universidadeDeFormacaoModal">Universidade de Formação:</label>
                        <input name="universidadeDeFormacaoModal" id="universidadeDeFormacaoModal" class="form-control" placeholder="Informe sua universidade de formação" type="text" required>
                    </div>
                    <div class="form-group">
                        <label for="descricao">Descrição sobre o instrutor:</label>
                        <textarea name="descricaoModal" id="descricaoModal" class="form-control" placeholder="Informe uma breve descrição" cols="10" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn-positive" id="button" onclick="alterar()">Alterar</button>
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="modalExcluirInstrutor" data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Excluir Instrutor</h2>
                </div>
                <div class="modal-body">
                    <h3>Você tem certeza que deseja excluir o instrutor?</h3>
                </div>
                <div class="modal-footer">
                    <button class="btn-negative" onclick="excluirInstrutor()">Sim</button>
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
                    url: "../../controle/instrutorControle.php",
                    type: "POST",
                    data: {
                        acao: "pegarTodos",
                    },
                    success: function(retorno) {
                        var result = JSON.parse(retorno);
                        
                        if (Array.isArray(result) && result.length > 0) {
                            var tabelaBody = document.getElementById("tabelaInstrutores");
                            var modalBody = document.getElementById("instrutor");
                            var nomeInstrutor = document.getElementById("nomeInstrutor");
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

                                var tdCref = document.createElement("td");
                                tdCref.innerText = item.cref;
                                tr.appendChild(tdCref);

                                var tdDataNascimento = document.createElement("td");
                                tdDataNascimento.innerText = item.dataDeNascimento;
                                tr.appendChild(tdDataNascimento);

                                var tdSexo = document.createElement("td");
                                tdSexo.innerText = item.sexo;
                                tr.appendChild(tdSexo);

                                var tdUniversidade = document.createElement("td");
                                tdUniversidade.innerText = item.universidadeDeFormacao;
                                tr.appendChild(tdUniversidade);

                                // Adiciona a nova linha na tabela
                                tabelaBody.appendChild(tr);

                                // Adiciona evento de clique na linha
                                tr.addEventListener("click", function() {
                                    // Exibe os dados no modal
                                    nomeInstrutor.innerText = item.nome;

                                    modalBody.innerHTML = `
                                        <p><strong>Email:</strong> ${item.email}</p>
                                        <p><strong>Registro CREF:</strong> ${item.cref}</p>
                                        <p><strong>Data de Nascimento:</strong> ${item.dataDeNascimento}</p>
                                        <p><strong>Sexo:</strong> ${item.sexo}</p>
                                        <p><strong>Data de Formação:</strong> ${item.dataDeFormacao}</p>
                                        <p><strong>Universidade de Formação:</strong> ${item.universidadeDeFormacao}</p>
                                        <p><strong>Descrição:</strong> ${item.descricao}</p>
                                    `;
                                    modalFooter.innerHTML = `
                                        <button class="btn-positive" onclick="openModalAlterarInstrutor(${item.idInstrutor})">Alterar Instrutor</button>
                                        <button class="btn-negative" onclick="openModalExcluirInstrutor(${item.idInstrutor})">Excluir Instrutor</button>
                                        <button class="btn-neutral" type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
                                    `;
                                    pegarFichaDeTreino(item.idInstrutor);
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

            function pegarFichaDeTreino(idInstrutor) {
                $.ajax({
                    url: "../../controle/fichaDeTreinoControle.php",
                    type: "POST",
                    data: {
                        acao: "pegarPorId",
                        idInstrutor: idInstrutor
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

            function cadastrar(){
                $.ajax({
                    url: "../../controle/instrutorControle.php",
                    type: "POST",
                    data: {
                        acao: "cadastrar",
                        nome: $("#nome").val(),
                        email: $("#email").val(),
                        senha: $("#senha").val(),
                        cref: $("#cref").val(),
                        dataDeNascimento: $("#dataDeNascimento").val(),
                        sexo: $("#sexo").val(),
                        dataDeFormacao: $("#dataDeFormacao").val(),
                        universidadeDeFormacao: $("#universidadeDeFormacao").val(),
                        descricao: $("#descricao").val(),
                    },
                    success: function(retorno){
                        window.location.href = "instrutores.php";
                    }
                });
            }

            var idInstrutor;
            function openModalAlterarInstrutor(idInstrutor){
                idAtual = idInstrutor;
                $.ajax({
                    url: "../../controle/instrutorControle.php",
                    type: "POST",
                    data: {
                        acao: "pegarPorId",
                        idInstrutor: idAtual
                    },
                    success: function(retorno) {
                        if (Array.isArray(retorno) && retorno.length > 0) {
                            var instrutor = retorno[0];  // Pega o primeiro objeto
                            // Preenche os campos na tabela
                            document.getElementById("nomeModal").value = instrutor.nome;
                            document.getElementById("emailModal").value = instrutor.email;
                            document.getElementById("crefModal").value = instrutor.cref;
                            document.getElementById("dataDeNascimentoModal").value= instrutor.dataDeNascimento;
                            document.getElementById("sexoModal").value = instrutor.sexo;
                            document.getElementById("dataDeFormacaoModal").value = instrutor.dataDeFormacao;
                            document.getElementById("universidadeDeFormacaoModal").value = instrutor.universidadeDeFormacao;
                            document.getElementById("descricaoModal").value = instrutor.descricao;
                        } else {
                            console.error('Nenhum dado foi retornado.');
                        }
                    },
                    error: function(error) {
                        console.error('Erro ao carregar dados do praticante:', error);
                    }
                });
                $("#modalAlterarInstrutor").modal("show");
            }

            function alterar(idInstrutor) {
                $.ajax({
                    url: "../../controle/instrutorControle.php",
                    type: "POST",
                    data: {
                        acao: "alterar",
                        idInstrutor: idAtual,
                        nome: $("#nomeModal").val(),
                        email: $("#emailModal").val(),
                        senha: $("#senhaModal").val(),
                        cref: $("#crefModal").val(),
                        dataDeNascimento: $("#dataDeNascimentoModal").val(),
                        sexo: $("#sexoModal").val(),
                        dataDeFormacao: $("#dataDeFormacaoModal").val(),
                        universidadeDeFormacao: $("#universidadeDeFormacaoModal").val(),
                        descricao: $("#descricaoModal").val(),
                    },
                    success: function(retorno) {
                        alert("Dados Alterados com Sucesso!");
                        location.reload();
                    }
                });
            }

            function openModalExcluirInstrutor(idInstrutor) {
            idAtual = idInstrutor;
            $('#modalExcluirInstrutor').modal('show'); 
        }

        function excluirInstrutor() {
            $.ajax({
                url: "../../controle/instrutorControle.php",
                type: "POST",
                data: {
                    acao: "excluir",
                    idInstrutor: idAtual, 
                },
                success: function(retorno) {
                    alert("Instrutor excluído com sucesso!");
                    location.reload();
                },
                error: function(error) {
                    console.error('Erro ao excluir instrutor:', error);
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
    <!-- Bootstrap e Popper JS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</html>