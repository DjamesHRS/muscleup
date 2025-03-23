<?php
session_start();
if (!isset($_SESSION["idPraticante"])) {
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
    <link rel="stylesheet" href="../../utilitarios/style.css">
    <title>Perfil do Praticante</title>
</head>
<body class="body-principal">
    <div id="navbar"></div>

    <!-- Conteúdo Principal -->
    <div id="main">
        <h1>Perfil do Praticante</h1>
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
                <th>Data de Nascimento</th>
                <td id="dataDeNascimento"></td>
            </tr>
            <tr>
                <th>Sexo</th>
                <td id="sexo"></td>
            </tr>
            <tr>
                <th>Altura</th>
                <td id="altura"></td>
            </tr>
            <tr>
                <th>Peso</th>
                <td id="peso"></td>
            </tr>
        </table>
        <div class="buttons">
        <button class="btn-neutral" type="button" data-bs-toggle="modal" data-bs-target="#myModal">Alterar</button>
        <button class="btn-negative" id="btnSair" onclick="openLogout()">Sair</button>
        </div>
    </div>

    <div class="modal" id="myModal" data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Alterar Dados</h2>
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
                        <input name="senhaModal" id="senhaModal" class="form-control" placeholder="Informe sua senha" type="password" required>
                    </div>
                    <div class="form-group">
                        <label for="dataDeNascimentoModal">Data de Nascimento:</label>
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
                        <select name="sexoModal" id="sexoModal" class="form-control">
                            <option value="">Selecione</option>
                            <option value="feminino">Feminino</option>
                            <option value="masculino">Masculino</option>
                            <option value="outro">Outro</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn-positive" onclick="alterar()">Alterar</button>
                    <button class="btn-negative" type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
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
        var idPraticante;
        $(document).ready(function() {
            // Define idPraticante e chama a função pegarPorId
            var idPraticante = <?php echo json_encode($_SESSION["idPraticante"]); ?>;
            pegarPorId(idPraticante);

            // Evento para preencher o modal antes de ser mostrado
            $('#myModal').on('show.bs.modal', function (event) {
                abrirModal(); // Chama a função para carregar dados do praticante no modal
            });
        });

        // Função para buscar dados do praticante pelo ID
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
                        // Preenche os campos na tabela
                        document.getElementById("nome").innerText = praticante.nome;
                        document.getElementById("email").innerText = praticante.email;
                        document.getElementById("dataDeNascimento").innerText = praticante.dataDeNascimento;
                        document.getElementById("sexo").innerText = praticante.sexo;
                        document.getElementById("altura").innerText = praticante.altura;
                        document.getElementById("peso").innerText = praticante.peso;
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

        function abrirModal() {
            var idPraticante = <?php echo json_encode($_SESSION["idPraticante"]); ?>;
            pegarPorIdModal(idPraticante); // Carrega os dados do praticante no modal
        }

        function pegarPorIdModal(idPraticante) {
            $.ajax({
                url: "../../controle/praticanteControle.php",
                type: "POST",
                data: {
                    acao: "pegarPorId",
                    idPraticante: idPraticante
                },
                success: function(retorno) {
                    if (Array.isArray(retorno) && retorno.length > 0) {
                        var praticante = retorno[0]; // Pega o primeiro objeto
                        // Preenche os campos do modal
                        $("#nomeModal").val(praticante.nome);
                        $("#emailModal").val(praticante.email);
                        $("#dataDeNascimentoModal").val(praticante.dataDeNascimento);
                        $("#senhaModal").val(''); // Limpa o campo de senha
                        $("#alturaModal").val(praticante.altura);
                        $("#pesoModal").val(praticante.peso);
                        $("#sexoModal").val(praticante.sexo);
                    } else {
                        console.error('Nenhum dado foi retornado.');
                    }
                },
                error: function(error) {
                    console.error('Erro ao carregar dados do praticante:', error);
                }
            });
        }

        function alterar() {
            var idPraticante = <?php echo json_encode($_SESSION["idPraticante"]); ?>;
            $.ajax({
                url: "../../controle/praticanteControle.php",
                type: "POST",
                data: {
                    acao: "alterar",
                    idPraticante: idPraticante,
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
                    window.location.href = "perfil.php";
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

    <!-- Bootstrap e Popper JS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
