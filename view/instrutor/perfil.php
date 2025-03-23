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
        <title>Perfil do Instrutor</title>
    </head>
    <div id="navbar"></div>
        <!-- Conteúdo Principal -->
        <div class="body-principal">
            <div id="main">
            <h1>Perfil do Instrutor</h1>
            <table id="tabelaPraticante" class="table lateral-table">
                <tr>
                    <th>Nome</th>
                    <td id="nome"></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td id="email"></td>
                </tr>
                <tr>
                    <th>Registro CREF</th>
                    <td id="cref"></td>
                </tr>
                <tr>
                    <th>Data de Nascimento</th>
                    <td id="dataDeNascimento"></td>
                </tr>
                <tr>
                    <th>Sexo</th>
                    <td id="sexo"></td>
                </tr>
                <tr>
                    <th>Data de Formação</th>
                    <td id="dataDeFormacao"></td>
                </tr>
                <tr>
                    <th>Universidade de Formação</th>
                    <td id="universidadeDeFormacao"></td>
                </tr>
                <tr>
                    <th>Descrição</th>
                    <td id="descricao"></td>
                </tr>
            </table>

            <div class= "buttons">
            <button onclick="pegarPorIdModal()" class="btn-neutral" type="button" data-bs-toggle="modal" data-bs-target="#myModal">Alterar</button>
            <button class="btn-negative" id="btnSair" onclick="openLogout()">Sair</button>
            </div>
            </div>
        </div>
        <div class="modal" id="myModal" data-bs-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2>Alterar Dados</h2>
                    </div>
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
                    <input name="senhaModal" id="senhaModal" class="form-control" placeholder="Informe sua senha" type="password" required>
                </div>
                <div class="form-group">
                    <label for="crefModal">Registro do CREF:</label>
                    <input name="crefModal" id="crefModal" class="form-control" placeholder="Informe seu CREF" type="texte">
                </div>
                <div class="form-group">
                    <label for="dataDeNascimentoModal">Data de Nascimento:</label>
                    <input name="dataDeNascimentoModal" id="dataDeNascimentoModal" class="form-control" placeholder="Informe sua data de nascimento" type="date">
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
                <div class="form-group">
                    <label for="dataDeFormacaoModal">Data de Formação:</label>
                    <input name="dataDeFormacaoModal" id="dataDeFormacaoModal" class="form-control" placeholder="Informe sua data de formação" type="date">
                </div>
                <div class="form-group">
                    <label for="universidadeDeFormacaoModal">Universidade de Formação:</label>
                    <input name="universidadeDeFormacaoModal" id="universidadeDeFormacaoModal" class="form-control" placeholder="Informe sua universidade de formação" type="text">
                </div>
                <div class="form-group">
                    <label for="descricaoModal">Descrição sobre o instrutor:</label>
                    <textarea name="descricaoModal" id="descricaoModal" class="form-control" placeholder="Informe uma breve descrição" cols="10" rows="3"></textarea>
                </div>
                    <div class="modal-footer">
                        <button class="btn-positive" onclick="alterar()">Alterar</button>
                        <button type="button" class="btn-negative" data-bs-dismiss="modal">Fechar</button>
                    </div>
                    </div>
                    </div>
                </div>
            </div>

            <div class="modal" id="modalLogout" data-bs-backdrop="static">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2>Encerrar Sessão</h2>
                        </div>
                        <div class="modal-body">
                            <h3>Você tem certeza que deseja encerrar sua sessão?</h3>
                        </div>
                        <div class="modal-footer">
                            <button class="btn-negative" onclick="logout()">Sim</button>
                            <button class="btn-positive" type="button" class="btn btn-danger" data-bs-dismiss="modal">Não</button>

                        </div>
                    </div>
                </div>
            </div>

        <script src="../../utilitarios/jquery-3.7.1.min.js"></script>
        <script>
            var idInstrutor;
            $(document).ready(function() {
                var idInstrutor = <?php echo json_encode($_SESSION["idInstrutor"]); ?>;
                pegarPorId(idInstrutor);
            });

            // Função para buscar dados do praticante pelo ID
            function pegarPorId(idInstrutor) {
                $.ajax({
                    url: "../../controle/instrutorControle.php",
                    type: "POST",
                    data: {
                        acao: "pegarPorId",
                        idInstrutor: idInstrutor
                    },
                    success: function(retorno) {
                        // Verifica se o retorno é um array com dados
                        if (Array.isArray(retorno) && retorno.length > 0) {
                            var instrutor = retorno[0];  // Pega o primeiro objeto
                            // Preenche os campos na tabela
                            document.getElementById("nome").innerText = instrutor.nome;
                            document.getElementById("email").innerText = instrutor.email;
                            document.getElementById("cref").innerText = instrutor.cref;
                            document.getElementById("dataDeNascimento").innerText = instrutor.dataDeNascimento;
                            document.getElementById("sexo").innerText = instrutor.sexo;
                            document.getElementById("dataDeFormacao").innerText = instrutor.dataDeFormacao;
                            document.getElementById("universidadeDeFormacao").innerText = instrutor.universidadeDeFormacao;
                            document.getElementById("descricao").innerText = instrutor.descricao;
                            document.getElementById("nomeUsuario").innerText = instrutor.nome;
                        } else {
                            console.error('Nenhum dado foi retornado.');
                        }
                    },
                    error: function(error) {
                        console.error('Erro ao carregar dados do instrutor:', error);
                    }
                });
            }

            function pegarPorIdModal() {
                var idInstrutor = <?php echo json_encode($_SESSION["idInstrutor"]); ?>;
                $.ajax({
                    url: "../../controle/instrutorControle.php",
                    type: "POST",
                    data: {
                        acao: "pegarPorId",
                        idInstrutor: idInstrutor
                    },
                    success: function(retorno) {
                        console.log(retorno); // Adiciona log para verificar o retorno
                        if (Array.isArray(retorno) && retorno.length > 0) {
                            var instrutor = retorno[0];
                            $("#nomeModal").val(instrutor.nome);
                            $("#emailModal").val(instrutor.email);
                            $("#senhaModal").val('');
                            $("#crefModal").val(instrutor.cref);
                            $("#dataDeNascimentoModal").val(instrutor.dataDeNascimento);
                            $("#sexoModal").val(instrutor.sexo);
                            $("#dataDeFormacaoModal").val(instrutor.dataDeFormacao);
                            $("#universidadeDeFormacaoModal").val(instrutor.universidadeDeFormacao);
                            $("#descricaoModal").val(instrutor.descricao);
                        } else {
                            console.error('Nenhum dado foi retornado ou o formato está incorreto.');
                        }
                    },
                    error: function(error) {
                        console.error('Erro ao carregar dados do instrutor:', error);
                    }
                });
            }


            function alterar(){
                var idInstrutor = <?php echo json_encode($_SESSION["idInstrutor"]); ?>;
                $.ajax({
                    url: "../../controle/instrutorControle.php",
                    type: "POST",
                    data: {
                        acao: "alterar",
                        idInstrutor: idInstrutor,
                        nome: $("#nomeModal").val(),
                        email: $("#emailModal").val(),
                        senha: $("#senhaModal").val(),
                        cref: $("#crefModal").val(),
                        sexo: $("#sexoModal").val(),
                        dataDeNascimento: $("#dataDeNascimentoModal").val(),
                        dataDeFormacao: $("#dataDeFormacaoModal").val(),
                        universidadeDeFormacao: $("#universidadeDeFormacaoModal").val(),
                        descricao: $("#descricaoModal").val()
                    },
                    success: function(retorno){
                        alert("Dados Alterados com Sucesso!");
                        location.reload();
                    },
                    error: function(error) {
                        console.error("Erro ao alterar dados:", error);
                    }
                });
            }

        function openLogout() {
            $('#modalLogout').modal('show'); 
        }

        function logout() {
            $.ajax({
                url: "../../controle/usuarioControle.php",
                type: "POST",
                data: { acao: "sair" },
                success: function(response) {
                    if (response === "1") {
                        window.location.href = "../index.html";
                    } else {
                        alert("Erro ao encerrar a sessão.");
                    }
                },
                error: function() {
                    alert("Erro ao tentar se desconectar.");
                }
            });
        }
</script>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap JS Bundle com Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    </body>
    </html> 