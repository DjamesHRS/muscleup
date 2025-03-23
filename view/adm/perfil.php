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
    <title>Perfil do Administrador</title>
</head>
<body class="body-principal">
<div id="navbar"></div>
    <!-- Conteúdo Principal -->
    <div id="main">

    <div class="sec-bg">
            <h1>Perfil do Administrador</h1>
            <table id="tabelaPraticante" class="table lateral-table">
                <tr>
                    <th>Nome</th>
                    <td id="nome"></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td id="email"></td>
                </tr>
            </table>

            <div class="buttons">
            <button class="btn-negative" id="btnSair" onclick="openLogout()">Sair</button>
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
        var idAdm;
        $(document).ready(function() {
            var idAdm = <?php echo json_encode($_SESSION["idAdm"]); ?>;
            pegarPorId(idAdm);
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
                            document.getElementById("nome").innerText = adm.nome;
                            document.getElementById("email").innerText = adm.email;
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
</body>
    <!-- Bootstrap e Popper JS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</html>